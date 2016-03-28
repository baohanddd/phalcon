<?php
namespace Bob\Phalcon\Definition;


interface Token extends Id
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER  = 'user';

    /**
     * @return \App\Model\User
     */
    public function getUser();

    /**
     * @param string $userId
     * @return boolean
     */
    public function isSelf($userId);

    /**
     * @param string $role
     * @return boolean
     */
    public function isRole($role);

    /**
     * @param string $credential
     * @return array token detail
     */
    public function update($credential);
}