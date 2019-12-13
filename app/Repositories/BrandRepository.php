<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use App\Models\Brand;
use App\Traits\UploadAble;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Contracts\BrandContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class BrandRepository extends BaseRepository implements BrandContract
{
    Use UploadAble;

    /**
     * BrandRepository constructor.
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed|void
     */
    public function listBrands(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed|void
     * @throws ModelNotFoundException
     */
    public function findBrandById(int $id)
    {
        try{
            return $this->findOneOrFail($id);

        }catch (ModelNotFoundException $e){

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Brand|void
     */
    public function createBrand(array $params)
    {
        try{
            $collection = collect($params);

            $logo = null;

            if($collection->has('logo') && $params['logo'] instanceof UploadedFile){
                $logo = $this->uploadOne($params['logo'],'brands');

            }
            $merge = $collection->merge(compact('logo'));

            $brand = new Brand($merge->all());

            $brand->save();

            return $brand;

        }catch (QueryException $exception){

            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed|void
     */
    public function updateBrand(array $params)
    {
        $brand = $this->findBrandById($params['id']);

        $collection = collect($params)->except('_token');

        if($collection->has('logo') && $params['logo'] instanceof UploadedFile){

            if ($brand->logo != null){
                $this->deleteOne($brand->logo);
            }

            $logo = $this->uploadOne($params['logo'],'brands');
        }

        $merge = $collection->merge(compact('logo'));

        $brand->update($merge->all());

        return $brand;
    }

    /**
     * @param $id
     * @return bool|mixed|void
     */
    public function deleteBrand($id)
    {
        $brand = $this->findBrandById($id);

        if ($brand->logo != null){
            $this->deleteOne($brand->logo);
        }

        $brand->delete();

        return $brand;
    }

}
