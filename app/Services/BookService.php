<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Models\Book;
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
        $query = $this->filterByAuthors($query, $filters['authors']);
        $query = $this->filterByRating($query, $filters);

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


    private function filterByRating(Builder $query, $filters): Builder
    {
        (int) $startRating = $filters['start_rating'];
        (int) $endRating =  $filters['end_rating'];
         
        Validator::make($filters, [
            'start_rating' => 'nullable|numeric|between:0,5|less_than:end_rating',
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

    private function checkRatingFilter($startRating, $endRating) {
            if (!is_numeric($startRating) || !is_numeric($endRating)) {
    
                $this->errorResponse('Rating must be a number', 400);
            }
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
        $query = $this->book->newQuery();
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
