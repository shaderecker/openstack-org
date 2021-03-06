<?php

/**
 * Copyright 2015 OpenStack Foundation
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
class TagManagerField extends FormField
{
    public $Category;

    public function FieldHolder($attributes = array ())
    {
        $current_summit = $this->Category->Summit();
        $tag_groups     = [];
        foreach($current_summit->TrackTagGroups() as $group){
            $tag_groups[$group->Label] = $group;
        }

        $tag_array = array_fill_keys(array_keys($tag_groups), []);

        foreach ($this->Category->AllowedTags() as $tag) {
            $tag_group = $current_summit->getTagGroupFor($tag);
            if(is_null($tag_group)) continue;
            $tag_array[$tag_group->Label][] = ['tag' => $tag->Tag, 'id' => $tag->ID];
        }

        foreach ($tag_array as $group => &$tags) {
            if (empty($tags))
                unset($tag_array[$group]);
            else
                sort($tags);
        }

        $tags_json = json_encode($tag_array);
        JQueryValidateDependencies::renderRequirements(true, false);
        Requirements::customScript("var category_tags = {$tags_json};");

        Requirements::set_write_js_to_body(false);

        return parent::FieldHolder($attributes);
    }

    public function saveInto(DataObjectInterface $record) {
        if($this->name) {
            $tags = explode(',',$this->dataValue());
            if(!$record instanceof SummitEvent) return;
            $record->Tags()->removeAll();
            foreach($tags as $t)
            {
                $tag = Tag::get()->byID($t);
                if(is_null($tag)) continue;
                $record->Tags()->add($tag);
            }
        }
    }

    public function setValue($value) {
        if($value instanceof ManyManyList) {
            $tags = $value->toArray();
            $list = array();
            foreach ($tags as $t) {
                if ($t->Tag != '')
                    array_push($list, $t->ID);
            }
            $this->value = implode(',', $list);
        }
        if(is_string($value))
        {
            $this->value = $value;
        }

        return $this;
    }

    public function setCategory($category) {
        $this->Category = $category;
    }
}