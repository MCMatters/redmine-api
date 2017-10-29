<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use InvalidArgumentException;
use const true;
use function in_array;

/**
 * Class TimeEntry
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries
 */
class TimeEntry extends AbstractResource
{
    /**
     * @param array $filters
     * @param array $pagination
     * @param array $sorting
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Listing-time-entries
     */
    public function list(
        array $filters = [],
        array $pagination = ['offset' => 0, 'limit' => 25],
        array $sorting = []
    ): array {
        return $this->requestGet(
            '/time_entries.json',
            $this->buildQueryParameters(
                $filters,
                $pagination,
                ['sort' => $sorting]
            )
        );
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Showing-a-time-entry
     */
    public function get(int $id): array
    {
        return $this->requestGet("/time_entries/{$id}.json");
    }

    /**
     * @param int $id
     * @param float|int|string $hours
     * @param string $type Can be 'issue' or 'project'
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @throws InvalidArgumentException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Creating-a-time-entry
     */
    public function create(
        int $id,
        $hours,
        string $type = 'issue',
        array $data = []
    ): array {
        $this->checkReferencingType($type);

        $data = $this->sanitizeData($data, $this->getPermittedFields());

        $data = [
            'time_entry' => [
                    "{$type}_id" => $id,
                    'hours'      => $hours,
                ] + $data,
        ];

        return $this->requestPost('/time_entries.json', $data);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Updating-a-time-entry
     */
    public function update(int $id, array $data): array
    {
        $data = $this->sanitizeData($data, $this->getPermittedFields());

        return $this->requestPut("/time_entries/{$id}.json", $data);
    }

    /**
     * @param int $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Deleting-a-time-entry
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("time_entries/{$id}.json");
    }

    /**
     * @return array
     */
    protected function getPermittedFields(): array
    {
        return [
            'issue_id',
            'project_id',
            'spent_on',
            'hours',
            'activity_id',
            'comments',
        ];
    }

    /**
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    protected function checkReferencingType(string $type)
    {
        if (!in_array($type, ['issue', 'project'], true)) {
            throw new InvalidArgumentException('The $type must be as issue or project');
        }
    }
}
