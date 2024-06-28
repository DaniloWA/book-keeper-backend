<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Models\Book;
use App\Models\Review;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class BookService
{
    use ApiResponser;

    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Apply filters to a query builder instance.
     *
     * @param Builder $query The query builder instance.
     * @param array $filters The filters to apply.
     * @return Builder The modified query builder instance.
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        $query = $this->search($query, $filters['search'] ?? null);
        $query = $this->filterByAuthors($query, $filters['authors'] ?? null);
        $query = $this->filterByRating($query, $filters);
        $query = $this->filterByGenres($query, $filters['genres'] ?? null);
        $query = $this->filterByYear($query, $filters);
        $query = $this->filterByStatus($query, $filters['status'] ?? null);
        $query = $this->filterByPages($query, $filters);
        $query = $this->filterByReviews($query, $filters);
        $query = $this->filterByLikes($query, $filters);
        $query = $this->filterByRead($query);
        $query = $this->orderBy($query, $filters['order_by'] ?? null, $filters['order_direction'] ?? 'asc');

        return $query;
    }

    public function orderBy(Builder $query, $orderBy, $orderDirection)
    {
        $orderByMapping = [
            'author' => 'author_id',
            'rating' => 'average_rating',
            'rating' => 'ratings_count',
            // 'genre' => 'genres.name',
            'name' => 'name',
            'year' => 'year',
            'average_rating' => 'average_rating',
            'pages' => 'pages',
            'country' => 'country',
            'likes' => 'likes_count',
            'read' => 'read_count',
        ];

        $orderDirections = [
            'asc',
            'desc',
        ];

        $orderBy = strtolower($orderBy);

        if (!in_array($orderDirection, $orderDirections)) {
            $orderDirection = 'asc';
        }

        if (array_key_exists($orderBy, $orderByMapping)) {
            $orderByField = $orderByMapping[$orderBy];

            if ($orderByField !== null) {
                return $query->orderBy($orderByField, $orderDirection);
            }
        }

        return $query;
    }

    public function filterByStatus(Builder $query, $status): Builder
    {
        if (isset($status)) {
            $status = Validator::make(['status' => $status], [
                'status' => 'nullable|in:read,reading,abandoned,want_to_read',
            ])->validated();

            $query->whereHas('statistics', function ($query) use ($status) {
                $query->where('user_id', auth()->id());
                $query->where('status', $status);
            });
        }

        return $query;
    }


    private function filterByYear(Builder $query, $filters): Builder
    {
        $startYear = $filters['start_year'] ?? null;
        $endYear = $filters['end_year'] ?? null;

        Validator::make($filters, [
            'start_year' => 'nullable|digits:4|integer',
            'end_year' => 'nullable|digits:4|integer',
        ])->validate();

        if (isset($startYear) && isset($endYear)) {
            $query->whereBetween('year', [(int) $startYear, (int) $endYear]);
        }

        if (isset($startYear) && !isset($endYear)) {
            $query->where('year', (int) $startYear);
        }

        return $query;
    }

    public function search(Builder $query, $search)
    {
        if (isset($search)) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }
        return $query;
    }


    /**
     * Filters the query by the provided author IDs.
     *
     * @param Builder $query The query builder instance.
     * @param mixed $authorsID The author IDs to filter by.
     * @return Builder The modified query builder instance.
     */
    private function filterByAuthors(Builder $query, $authorsID): Builder
    {
        if (isset($authorsID)) {
            $authorsID = explode(',', $authorsID);

            $query->whereIn('author_id', $authorsID);
        }

        return $query;
    }

    private function filterByGenres(Builder $query, $genres): Builder
    {
        if (isset($genres)) {
            $genreIds = explode(',', $genres);
            return $query->whereHas('genres', function ($query) use ($genreIds) {
                $query->whereIn('genres.id', $genreIds);
            });
        }

        return $query;
    }

    private function filterByRating(Builder $query, $filters): Builder
    {
        (int) $startRating = $filters['start_rating'] ?? null;
        (int) $endRating =  $filters['end_rating'] ?? null;

        Validator::make($filters, [
            'start_rating' => 'nullable|numeric|between:0,5',
            'end_rating' => 'nullable|numeric|between:0,5',
        ])->validate();

        if (isset($startRating) && isset($endRating)) {
            return $query->whereBetween('average_rating', [$startRating, $endRating]);
        }

        if (isset($startRating) && !isset($endRating)) {
            return  $query->where('average_rating', $startRating);
        }

        return $query;
    }

    private function filterByPages(Builder $query, $filters): Builder
    {
        $startPages = isset($filters['start_pages']) ? (int) $filters['start_pages'] : null;
        $endPages = isset($filters['end_pages']) ? (int) $filters['end_pages'] : null;

        Validator::make($filters, [
            'start_pages' => 'nullable|numeric',
            'end_pages' => 'nullable|numeric',
        ])->validate();

        if (isset($startPages) && isset($endPages)) {
            return $query->whereBetween('pages', [$startPages, $endPages]);
        }

        if (isset($startPages) && !isset($endPages)) {
            return  $query->where('pages', $startPages);
        }

        return $query;
    }


    private function checkRatingFilter($startRating, $endRating)
    {
        if (!is_numeric($startRating) || !is_numeric($endRating)) {
            $this->errorResponse('Rating must be a number', 400);
        }
    }

    private function filterByReviews(Builder $query, $filters): Builder
    {
        Validator::make($filters, [
            'min_reviews' => 'nullable|numeric',
            'max_reviews' => 'nullable|numeric',
        ])->validate();

        $minReviews = isset($filters['min_reviews']) ? (int) $filters['min_reviews'] : null;
        $maxReviews = isset($filters['max_reviews']) ? (int) $filters['max_reviews'] : null;

        $query->withCount('reviews');

        if (isset($minReviews) && isset($maxReviews)) {
            return $query->having('reviews_count', '>=', $minReviews)->having('reviews_count', '<=', $maxReviews);
        }

        if (isset($minReviews)) {
            return $query->having('reviews_count', '=', $minReviews);
        }

        if (isset($maxReviews)) {
            return $query->having('reviews_count', '<=', $maxReviews);
        }

        return $query;
    }

    private function filterByLikes(Builder $query, $filters): Builder
    {
        Validator::make($filters, [
            'min_likes' => 'nullable|numeric',
            'max_likes' => 'nullable|numeric',
        ])->validate();

        $minLikes = isset($filters['min_likes']) ? (int) $filters['min_likes'] : null;
        $maxLikes = isset($filters['max_likes']) ? (int) $filters['max_likes'] : null;

        $query->withCount(['statistics as likes_count' => function ($query) {
            $query->where('liked', true);
        }]);

        if (isset($minLikes) && isset($maxLikes)) {
            return $query->having('likes_count', '>=', $minLikes)->having('likes_count', '<=', $maxLikes);
        }

        if (isset($minLikes)) {
            return $query->having('likes_count', '>=', $minLikes);
        }

        if (isset($maxLikes)) {
            return $query->having('likes_count', '<=', $maxLikes);
        }

        return $query;
    }

    private function filterByRead(Builder $query): Builder
    {
        $query->withCount(['statistics as read_count' => function ($query) {
            $query->where('status', 'read');
        }]);

        return $query;
    }


    /**
     * Retrieves a paginated list of tasks based on specified filters.
     *
     * @param array $filters The filters to be applied to the query.
     * @param int $perPage The number of tasks to be displayed per page.
     * @param int $page The current page number.
     * @throws Some_Exception_Class Description of the exception that can be thrown.
     * @return LengthAwarePaginator The paginated tasks.
     */
    public function getPaginatedBooks(array $filters, int $perPage, int $page): LengthAwarePaginator
    {
        $query = $this->book
            ->withGenres()
            ->withAuthor()
            ->withRatings()
            ->withStatistics()
            ->newQuery();

        $this->applyFilters($query, $filters);

        if (!empty($filters['countries'])) {
            $countries = explode(',', $filters['countries']);
            $query->whereIn('country', $countries);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getLastreadBooks($numberOfBooks = 10)
    {
        $lastBooksRead = Statistic::forCurrentUser()
            ->where('status', 'read')
            ->orderBy('id', 'desc')
            ->take($numberOfBooks)
            ->get();

        return $lastBooksRead;
    }
}
