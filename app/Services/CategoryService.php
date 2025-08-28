<?php
namespace App\Services;


    use App\Repositories\CategoryRepository;
    use Illuminate\Support\Facades\Storage;


    class CategoryService
    {
        protected $categoryRepository;

        public function __construct(CategoryRepository $categoryRepository)
        {
            $this->categoryRepository = $categoryRepository;
        }

        public function getAllCategories()
        {
            return $this->categoryRepository->getAllCategories();
        }
    public function createCategory($data)
    {
        return $this->categoryRepository->createCategory($data);
    }

    public function updateCategory($id, $data)
    {
        return $this->categoryRepository->updateCategory($id, $data);
    }

        public function deleteCategory($id)
        {
            return $this->categoryRepository->deleteCategory($id);
        }
    }

