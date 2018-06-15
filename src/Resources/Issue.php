<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const false;
use function array_merge, count, trim;

/**
 * Class Issue
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues
 */
class Issue extends AbstractResource
{
    /**
     * @param array $filters
     * @param array $pagination
     * @param array $sorting
     * @param array $include
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Listing-issues
     */
    public function list(
        array $filters = [],
        array $pagination = ['offset' => 0, 'limit' => 25],
        array $sorting = [],
        array $include = []
    ): array {
        return $this->httpClient->get(
            'issues.json',
            [
                $filters,
                $pagination,
                ['sort' => $sorting],
                ['include' => $include],
            ]
        );
    }

    /**
     * @param array $filters
     * @param array $include
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function all(array $filters = [], array $include = []): array
    {
        $all = [];
        $offset = 0;
        $count = 0;

        do {
            $list = $this->list(
                $filters,
                ['offset' => $offset, 'limit' => 100],
                [],
                $include
            );

            $all[] = $list['issues'];

            $count += count($list['issues']);
            $offset += 100;
        } while ($count < $list['total_count']);

        return array_merge([], ...$all);
    }

    /**
     * @param array $include
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function allMine(array $include = []): array
    {
        return $this->all(['assigned_to_id' => 'me'], $include);
    }

    /**
     * @param int $id
     * @param array $include
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Showing-an-issue
     */
    public function get(int $id, array $include = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->get(
                "issues/{$id}.json",
                [['include' => $include]]
            ),
            'issue'
        );
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Creating-an-issue
     */
    public function create(array $data): array
    {
        return $this->getDataByKey(
            $this->httpClient->post('issues.json', ['issue' => $data]),
            'issue'
        );
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Updating-an-issue
     */
    public function update(int $id, array $data): array
    {
        return $this->httpClient->put("issues/{$id}.json", ['issue' => $data]);
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Deleting-an-issue
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("issues/{$id}.json");
    }

    /**
     * @param int $id
     * @param bool $skipSystem
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function getNotes(int $id, bool $skipSystem = false): array
    {
        $notes = $this->getDataByKey($this->get($id, ['journals']), 'journals');

        return $skipSystem ? $this->filterSystemNotes($notes) : $notes;
    }

    /**
     * @param int $id
     * @param string $note
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function addNote(int $id, string $note): array
    {
        return $this->update($id, ['notes' => $note]);
    }

    /**
     * @param int $id
     * @param int $statusId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function updateStatus(int $id, int $statusId): array
    {
        return $this->update($id, ['status_id' => $statusId]);
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Adding-a-watcher
     */
    public function addWatcher(int $id, int $userId): array
    {
        return $this->httpClient->post(
            "issues/{$id}/watchers.json",
            ['user_id' => $userId]
        );
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Removing-a-watcher
     */
    public function removeWatcher(int $id, int $userId): bool
    {
        return $this->httpClient->delete("issue/{$id}/watchers/{$userId}.json");
    }

    /**
     * @param array $notes
     *
     * @return array
     */
    protected function filterSystemNotes(array $notes): array
    {
        $filtered = [];

        foreach ($notes as $key => $note) {
            $note['notes'] = trim($note['notes'] ?? '');

            if ('' !== $note['notes']) {
                $filtered[] = $note;
            }
        }

        return $filtered;
    }
}
