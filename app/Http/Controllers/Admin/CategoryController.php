<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\ApiControllerTrait;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiControllerTrait;

    /**
     * @param  Request  $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        return CategoryRepository::getCategoryTree();
    }

    /**
     * @param  CategoryRequest  $request
     *
     * @return mixed
     */
    public function store(CategoryRequest $request)
    {
        if (!empty($request->get('name'))) {
            $request->merge(['slug' => $this->slug($request->get('name'))]);
        }
        $parentId = (int) $request->get('parent_id');
        if ($parentId !== 0 && $parent = Category::find($parentId, ['slug'])) {
            $request->merge(['parent_slug' => $parent->slug]);
        }
        Cache::forget('api.category.tree');
        return Category::create($request->all());
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return Category::findOrFail($id, [
            'id', 'parent_id', 'name', 'title', 'description', 'cl_icon',
            'cl_background'
        ]);
    }

    /**
     * @param  CategoryRequest  $request
     * @param                   $id
     *
     * @return mixed
     */
    public function update(CategoryRequest $request, $id)
    {
        $question = Category::findOrFail($id, [
            'id', 'parent_id', 'title', 'name', 'description', 'cl_icon',
            'cl_background'
        ]);
        if (!empty($request->get('name'))
            && mb_strtolower($request->get('name'))
            !== mb_strtolower($question->name)
        ) {
            $request->merge(['slug' => $this->slug($request->get('name'))]);
        }
        $question->update($request->all());

        Cache::forget('api.category.tree');
        return $question;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        Cache::forget('api.category.tree');
        return $this->successResponse();
    }

    private function slug($stroka)
    {
        $rus = [
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л',
            'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш',
            'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е',
            'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с',
            'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю',
            'я', ' '
        ];

        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh',
            'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e',
            'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e',
            'yu', 'ya', ' '
        ];

        $stroka = str_replace($rus, $lat, $stroka); // перевеодим на английский
        $stroka = str_replace('-', '', $stroka); // удаляем все исходные "-"
        $slag = preg_replace('/[^A-Za-z0-9-]+/', '-',
            $stroka); // заменяет все символы и пробелы на "-"
        return $slag;
    }
}
