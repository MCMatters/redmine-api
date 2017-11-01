<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const false, true;
use function array_merge, array_values, trim;

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
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Listing-issues
     */
    public function list(
        array $filters = [],
        array $pagination = ['offset' => 0, 'limit' => 25],
        array $sorting = [],
        array $includes = []
    ): array {
        return $this->requestGet(
            '/issues.json',
            $this->buildQueryParameters(
                $filters,
                $pagination,
                ['sort' => $sorting],
                ['include' => $includes]
            )
        );
    }

    /**
     * @param int $id
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Showing-an-issue
     */
    public function get(int $id, array $includes = []): array
    {
        return $this->requestGet(
            "/issues/{$id}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Creating-an-issue
     */
    public function create(array $data): array
    {
        $data = $this->sanitizeData($data, $this->getPermittedFields());

        return $this->requestPost('/issues.json', ['issue' => $data]);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Updating-an-issue
     */
    public function update(int $id, array $data = []): array
    {
        $data = $this->sanitizeData($data, $this->getPermittedFields(true));

        return $this->requestPut("/issues/{$id}.json", ['issue' => $data]);
    }

    /**
     * @param int $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Deleting-an-issue
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("/issues/{$id}.json");
    }

    /**
     * @param int $id
     * @param bool $skipSystem
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function getNotes(int $id, bool $skipSystem = false): array
    {
        $data = $this->get($id, ['journals']);

        $notes = $data['issue']['journals'];

        return $skipSystem ? $this->filterSystemNotes($notes) : $notes;
    }

    /**
     * @param int $id
     * @param string $note
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
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
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
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
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Adding-a-watcher
     */
    public function addWatcher(int $id, int $userId): array
    {
        return $this->requestPost(
            "/issues/{$id}/watchers.json",
            ['user_id' => $userId]
        );
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Issues#Removing-a-watcher
     */
    public function removeWatcher(int $id, int $userId): int
    {
        return $this->requestDelete("/issue/{$id}/watchers/{$userId}.json");
    }

    /**
     * @param bool $updating
     *
     * @return array
     */
    protected function getPermittedFields(bool $updating = false): array
    {
        $baseFields = [
            'project_id',
            'tracker_id',
            'status_id',
            'priority_id',
            'subject',
            'description',
            'category_id',
            'fixed_version_id',
            'assigned_to_id',
            'parent_issue_id',
            'custom_fields',
            'watcher_user_ids',
            'is_private',
            'estimated_hours',
        ];

        return !$updating
            ? $baseFields
            : array_merge($baseFields, ['notes', 'private_notes']);
    }

    /**
     * @param array $notes
     *
     * @return array
     */
    protected function filterSystemNotes(array $notes): array
    {
        foreach ($notes as $key => $note) {
            $note['notes'] = trim($note['notes'] ?? '');

            if ('' === $note['notes']) {
                unset($notes[$key]);
            }
        }

        return array_values($notes);
    }
}
