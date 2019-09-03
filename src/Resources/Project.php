<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use function array_merge, count;

/**
 * Class Project
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects
 */
class Project extends AbstractResource
{
    /**
     * @param array $query
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects#Listing-projects
     */
    public function list(array $query = []): array
    {
        return $this->httpClient->get('projects.json', $query);
    }

    /**
     * @param array $query
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function all(array $query = []): array
    {
        $all = [];
        $offset = 0;
        $count = 0;

        do {
            $list = $this->list(['offset' => $offset, 'limit' => 100] + $query);

            $all[] = $list['projects'];

            $count += count($list['projects']);
            $offset += 100;
        } while ($count < $list['total_count']);

        return array_merge([], ...$all);
    }

    /**
     * @param int|string $id
     * @param array $query
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects#Showing-a-project
     */
    public function get($id, array $query = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("projects/{$id}.json", $query),
            'project'
        );
    }

    /**
     * @param string $name
     * @param string $identifier
     * @param array $data
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects#Creating-a-project
     */
    public function create(
        string $name,
        string $identifier,
        array $data = []
    ): array {
        $data = ['name' => $name, 'identifier' => $identifier] + $data;

        return $this->getDataByKey(
            $this->httpClient->post('projects.json', ['project' => $data]),
            'project'
        );
    }

    /**
     * @param int|string $id
     * @param array $data
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects#Updating-a-project
     */
    public function update($id, array $data): array
    {
        return $this->httpClient->put("projects/{$id}.json", $data);
    }

    /**
     * @param int|string $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Projects#Deleting-a-project
     */
    public function delete($id): bool
    {
        return $this->httpClient->delete("projects/{$id}.json");
    }
}
