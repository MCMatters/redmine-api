<?php

declare(strict_types=1);

namespace McMatters\RedmineApi;

use McMatters\RedmineApi\Resources\{
    Attachment, CustomField, Enumeration, File, Group, Issue, IssueCategory,
    IssueRelation, IssueStatus, News, Project, ProjectMembership, Query, Role,
    TimeEntry, Tracker, User, Version, Wiki
};

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
        return $this->resource(Attachment::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\CustomField
     */
    public function customField(): CustomField
    {
        return $this->resource(CustomField::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Enumeration
     */
    public function enumeration(): Enumeration
    {
        return $this->resource(Enumeration::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\File
     */
    public function file(): File
    {
        return $this->resource(File::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Group
     */
    public function group(): Group
    {
        return $this->resource(Group::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Issue
     */
    public function issue(): Issue
    {
        return $this->resource(Issue::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueCategory
     */
    public function issueCategory(): IssueCategory
    {
        return $this->resource(IssueCategory::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueRelation
     */
    public function issueRelation(): IssueRelation
    {
        return $this->resource(IssueRelation::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\IssueStatus
     */
    public function issueStatus(): IssueStatus
    {
        return $this->resource(IssueStatus::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\News
     */
    public function news(): News
    {
        return $this->resource(News::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Project
     */
    public function project(): Project
    {
        return $this->resource(Project::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\ProjectMembership
     */
    public function projectMembership(): ProjectMembership
    {
        return $this->resource(ProjectMembership::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Query
     */
    public function query(): Query
    {
        return $this->resource(Query::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Role
     */
    public function role(): Role
    {
        return $this->resource(Role::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\TimeEntry
     */
    public function timeEntry(): TimeEntry
    {
        return $this->resource(TimeEntry::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Tracker
     */
    public function tracker(): Tracker
    {
        return $this->resource(Tracker::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\User
     */
    public function user(): User
    {
        return $this->resource(User::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Version
     */
    public function version(): Version
    {
        return $this->resource(Version::class);
    }

    /**
     * @return \McMatters\RedmineApi\Resources\Wiki
     */
    public function wiki(): Wiki
    {
        return $this->resource(Wiki::class);
    }

    /**
     * @param string $class
     *
     * @return mixed
     */
    protected function resource(string $class)
    {
        if (!isset($this->resources[$class])) {
            $this->resources[$class] = new $class(
                $this->baseUrl,
                $this->apiKey
            );
        }

        return $this->resources[$class];
    }
}
