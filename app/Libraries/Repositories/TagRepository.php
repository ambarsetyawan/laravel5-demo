<?php

namespace App\Libraries\Repositories;


use App\Tag;
use Illuminate\Support\Facades\Schema;

class TagRepository
{

	/**
	 * Returns all Tags
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Tag::all();
	}

	public function search($input)
    {
        $query = Tag::query();

        $columns = Schema::getColumnListing('tags');
        $attributes = array();

        foreach($columns as $attribute){
            if(isset($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] =  $input[$attribute];
            }else{
                $attributes[$attribute] =  null;
            }
        };

        return [$query->get(), $attributes];

    }

	/**
	 * Stores Tag into database
	 *
	 * @param array $input
	 *
	 * @return Tag
	 */
	public function store($input)
	{
		return Tag::create($input);
	}

	/**
	 * Find Tag by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Tag
	 */
	public function findTagById($id)
	{
		return Tag::find($id);
	}

	/**
	 * Updates Tag into database
	 *
	 * @param Tag $tag
	 * @param array $input
	 *
	 * @return Tag
	 */
	public function update($tag, $input)
	{
		$tag->fill($input);
		$tag->save();

		return $tag;
	}
}