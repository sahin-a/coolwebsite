<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/model/UserModel/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/model/UserModel/Profile.php");

class User
{
    public ?string $id;
    public ?string $username;
    public ?Role $role;
    public ?Profile $profile;
}