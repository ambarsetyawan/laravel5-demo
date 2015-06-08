<?php

namespace App\Libraries\Repositories;


use App\Category;
use Illuminate\Support\Facades\Schema;

class CategoryRepository
{

	/**
	 * Returns all Categories
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Category::all();
	}

	public function search($input)
    {
        $query = Category::query();

        $columns = Schema::getColumnListing('categories');
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
	 * Stores Category into database
	 *
	 * @param array $input
	 *
	 * @return Category
	 */
	public function store($input)
	{
		return Category::create($input);
	}

	/**
	 * Find Category by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Category
	 */
	public function findCategoryById($id)
	{
		return Category::find($id);
	}

	/**
	 * Updates Category into database
	 *
	 * @param Category $category
	 * @param array $input
	 *
	 * @return Category
	 */
	public function update($category, $input)
	{
		$category->fill($input);
		$category->save();

		return $category;
	}
}