<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Project
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects
 */
class Project extends AbstractResource
{
    /**
     * @param array $pagination
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(
        array $pagination = ['offset' => 0, 'limit' => 25],
        array $includes = []
    ): array {
        $query = $this->buildQueryParameters(
            $pagination,
            ['include' => $includes]
        );

        return $this->requestGet('/projects.json', $query);
    }

    /**
     * @param int|string $id
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function get($id, array $includes = []): array
    {
        return $this->requestGet(
            "/projects/{$id}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param string $name
     * @param string $identifier
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function create(
        string $name,
        string $identifier,
        array $data = []
    ): array {
        $data = $this->sanitizeData(
            ['name' => $name, 'identifier' => $identifier] + $data,
            $this->getPermittedFields()
        );

        return $this->requestPost('/projects.json', ['project' => $data]);
    }

    /**
     * @param int|string $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function update($id, array $data): array
    {
        $data = $this->sanitizeData($data, $this->getPermittedFields());

        return $this->requestPut("projects/{$id}.json", $data);
    }

    /**
     * @param int|string $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function delete($id): int
    {
        return $this->requestDelete("projects/{$id}.json");
    }

    /**
     * @return array
     */
    protected function getPermittedFields(): array
    {
        return [
            'name',
            'identifier',
            'description',
            'homepage',
            'is_public',
            'parent_id',
            'inherit_members',
            'tracker_ids',
            'enabled_module_names',
        ];
    }
}
