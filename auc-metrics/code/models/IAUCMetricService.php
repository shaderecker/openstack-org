<?php
/**
 * Copyright 2020 Open Infrastructure Foundation
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
 * Interface IAUCMetricService
 */
interface IAUCMetricService
{
    /**
     * @param int $error_id
     * @param int $member_id
     * @return mixed
     * @throws NotFoundEntityException
     */
    public function fixMissMatchUserError($error_id, $member_id);

    /**
     * @param int $error_id
     * @throws NotFoundEntityException
     * @return mixed
     */
    public function deleteMissMatchUserError($error_id);
}