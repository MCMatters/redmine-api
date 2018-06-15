<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi;

use McMatters\RedmineApi\Contracts\ResourceContract;
use McMatters\RedmineApi\Resources\{
    Attachment, CustomField, Enumeration, File, Group, Issue, IssueCategory,
    IssueRelation, IssueStatus, News, Project, ProjectMembership, Query, Role,
    TimeEntry, Tracker, User, Version, Wiki
};
use function ucfirst;

/**
 * Class RedmineClient
 *
 * @package McMatters\RedmineApi
 */
class RedmineClient
{
    /**
     * @var array
     */
    protected $resources;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Redmine constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     */
    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Attachment
     */
    public function attachment(): Attachment
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\CustomField
     */
    public function customField(): CustomField
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Enumeration
     */
    public function enumeration(): Enumeration
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\File
     */
    public function file(): File
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Group
     */
    public function group(): Group
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Issue
     */
    public function issue(): Issue
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueCategory
     */
    public function issueCategory(): IssueCategory
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueRelation
     */
    public function issueRelation(): IssueRelation
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueStatus
     */
    public function issueStatus(): IssueStatus
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\News
     */
    public function news(): News
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Project
     */
    public function project(): Project
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\ProjectMembership
     */
    public function projectMembership(): ProjectMembership
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Query
     */
    public function query(): Query
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Role
     */
    public function role(): Role
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\TimeEntry
     */
    public function timeEntry(): TimeEntry
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Tracker
     */
    public function tracker(): Tracker
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\User
     */
    public function user(): User
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Version
     */
    public function version(): Version
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Wiki
     */
    public function wiki(): Wiki
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @param string $name
     *
     * @return \McMatters\RedmineApi\Contracts\ResourceContract
     */
    protected function resource(string $name): ResourceContract
    {
        if (!empty($this->resources[$name])) {
            return $this->resources[$name];
        }

        $class = __NAMESPACE__.'\\Resources\\'.ucfirst($name);

        $this->resources[$name] = new $class(
            $this->baseUrl,
            $this->apiKey
        );

        return $this->resources[$name];
    }
}
