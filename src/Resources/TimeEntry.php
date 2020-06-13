<?php

declare(strict_types=1);

namespace McMatters\RedmineApi\Resources;

use InvalidArgumentException;

use function in_array;

use const true;

/**
 * Class TimeEntry
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries
 */
class TimeEntry extends AbstractResource
{
    /**
     * @param array $query
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Listing-time-entries
     */
    public function list(array $query = []): array
    {
        return $this->httpClient->get('time_entries.json', $query);
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Showing-a-time-entry
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("time_entries/{$id}.json"),
            'time_entry'
        );
    }

    /**
     * @param int $id
     * @param float|int|string $hours
     * @param string $type Can be 'issue' or 'project'
     * @param array $data
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Creating-a-time-entry
     */
    public function create(
        int $id,
        $hours,
        string $type = 'issue',
        array $data = []
    ): array {
        $this->checkReferencingType($type);

        $data = ['time_entry' => ["{$type}_id" => $id, 'hours' => $hours] + $data];

        return $this->getDataByKey(
            $this->httpClient->post('time_entries.json', $data),
            'time_entry'
        );
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Updating-a-time-entry
     */
    public function update(int $id, array $data): array
    {
        return $this->httpClient->put("time_entries/{$id}.json", $data);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_TimeEntries#Deleting-a-time-entry
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("time_entries/{$id}.json");
    }

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     */
    protected function checkReferencingType(string $type)
    {
        if (!in_array($type, ['issue', 'project'], true)) {
            throw new InvalidArgumentException(
                'The type must be as "issue" or "project"'
            );
        }
    }
}
