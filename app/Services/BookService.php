<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
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
        $query = $this->book->withGenres()->withAuthor()->withRatings()->newQuery();
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
