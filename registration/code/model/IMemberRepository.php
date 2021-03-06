<?php
/**
 * Copyright 2014 Openstack Foundation
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/

/**
 * Interface IMemberRepository
 */
interface IMemberRepository extends IEntityRepository
{
    /**
     * @param string $email
     * @return Member|null
     */
    public function findByEmail($email);

    /**
     * @param string $email
     * @return Member|null
     */
    public function findByPrimaryEmail($email);

    /**
     * @param string $first_name
     * @param string $last_name
     * @return array
     */
    public function getAllByName($first_name, $last_name);

    /**
     * @param string $email_verification_token
     * @return Member|null
     */
    public function getByEmailVerificationToken($email_verification_token);

    /**
     * @param string $external_id
     * @return Member|null
     */
    public function findByExternalId(string $external_id):?Member;
} 