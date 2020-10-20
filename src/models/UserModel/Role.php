<?php


class Role
{
    private $roleName;

    public function getRoleName() {
        return $this->roleName;
    }

    public function __construct(string $roleName)
    {
        $this->$roleName = $roleName;
    }
}