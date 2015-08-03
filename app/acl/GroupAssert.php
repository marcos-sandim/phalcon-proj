<?php
namespace App\Acl;

class GroupAssert
{
    public function editAssert($parameters)
    {
        $groupId = array_shift($parameters);
        $group = \App\Models\Group::findFirstById($groupId);
        return (bool) $group;
    }

    public function deactivateAssert($parameters)
    {
        $groupId = array_shift($parameters);
        $group = \App\Models\Group::findFirstById($groupId);
        return $group && $group->active;
    }

    public function reactivateAssert($parameters)
    {
        $groupId = array_shift($parameters);
        $group = \App\Models\Group::findFirstById($groupId);
        return $group && !$group->active;
    }

    public function manageAccessAssert($parameters)
    {
        $groupId = array_shift($parameters);
        $group = \App\Models\Group::findFirstById($groupId);
        return $group && !$group->is_admin;
    }
}