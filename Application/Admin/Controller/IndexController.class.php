<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    //  登入界面
    public function index()
    {
//        dump(WWW_PATH);exit;
        $this->display('Index/login');
    }

    //  登入操作 跳转到地标列表
    public function checkLogin()
    {
        $username = I('username');
        $password = MD5(I('password'));
        $admin = M('users');
        $admin = $admin->where("name = '{$username}' and pwd = '{$password}'")->find();
        if (!empty($admin)) {
            session('user', $admin['id']);
            $this->success('登入成功，跳转中', 'brandList', 1);
        } else {
            $this->error('登入失败', '', 2);
        }
    }

    public function brandList()
    {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }
        $brand = M('brand');
        $brand = $brand->where('status = 1')->select();
        if (!empty($brand)) {
            $this->assign('brand', $brand);
        }
        $this->display('Index/brandList');
    }

//编辑珠宝品牌
    public function editBrand()
    {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }

        $brand_id = I('brand_id');
        if ($brand_id) {
            $brand = M('brand');
            $brand = $brand->where('brand_id=' . $brand_id)->find();
            $this->assign('b', $brand);
        }
        $this->display('Index/editBrand');
    }

    public function addBrand()
    {
        $h_id = I('id');
        $brand_name = I('brand_name');
        $brand = M('brand');
        $brand_shop_url = I('brand_shop_url');
        if (!strstr($brand_shop_url,'http')) {
            $brand_shop_url = 'http://'.$brand_shop_url;
        }
        if (empty($brand_name)) {
            $this->error('品牌不能为空', '', 1);
        }
        if ($h_id) {
            if ($_FILES['logo_img']['error'] == 0) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = WWW_PATH.'/Public'; // 设置附件上传根目录
                $upload->savePath = '/uploads/logo/'; // 设置附件上传（子）目录
                $upload->autoSub = false;
                // 上传文件
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    $file = $info['logo_img'];
                    $brand->logo_img = '/Public' . $file['savepath'] . $file['savename'];
                }
            }
            $brand->brand_shop_url = $brand_shop_url;
            $condition['brand_name'] = $brand_name;
            if ($brand->where($condition)->save() !== false) {
                $this->success('编辑成功', 'brandList', 1);
            }
        } else {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = WWW_PATH.'/Public/uploads/'; // 设置附件上传根目录
            $upload->savePath = 'logo/'; // 设置附件上传（子）目录
            $upload->autoSub = false;
            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {
                $file = $info['logo_img'];
//                $brand->logo_img = '/Public' . $file['savepath'] . $file['savename'];
                $brand->logo_img = '/Public/uploads/' . $file['savepath'] . $file['savename'];

            }
            $brand->brand_shop_url = $brand_shop_url;
            $brand->brand_name = $brand_name;
            $brand->create_time = date('Y-m-d H:i:s');
            if ($brand->add()) {
                $this->success('编辑成功', 'brandList', 1);
            }
        }
    }

    public function deleteBrand() {
        $id = I('brand_id');
        $delete = M('brand');
        if ($delete->delete($id) !== false) {
            $this->success('删除成功');
        }
    }

    public function categoryList()
    {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }
        $category = M('category');
        //  分页开始
        //  1 计算数据总条数
        //$count = $comment->where("status = 0")->count();
        $count = $category->count();
        //  2 实例化分页类
        $page = new \Think\Page($count, 20);
        $page->setConfig('first', '首页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //  3 分页输出
        $show = $page->show();
        $category = $category
            ->join('brand on category.b_id = brand.brand_id')
            ->where('category.status = 1')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign('page', $show);
        $this->assign('category', $category);
        $this->display('Index/categoryList');
    }

    public function editCategory()
    {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }
        //  品牌的分类列表
        $brand = M('brand');
        $category_brand = clone $brand;
        $condition['status'] = 1;
        $brand = $brand->where($condition)->select();
        if (empty($brand)) {
            $this->error('珠宝品牌未编辑', 'brandList', 1);
        }
        //  整理brand数组前台option要用的
        foreach ($brand as $b) {
            $results[$b['brand_id']] = $b['brand_name'];
        }

        $category_id = I('category_id');
        if ($category_id) {
            $category = M('category');
            $category = $category->where('category_id =' . $category_id)->find();
            $condition['brand_id'] = $category['b_id'];
            $category_brand = $category_brand->where($condition)->find();
            $this->assign('category', $category);
            $this->assign('brand_array', $results);
            $this->assign('category_brand', $category_brand);
        }
        $this->assign('brand', $brand);
        $this->display('Index/editCategory');
    }

    public function addCategory()
    {
        $type = I('type');
        $category_name = I('category_name');
        $category_id = I('category_id');
        $category = M('category');
        if ($type == -1) {
            $this->error('没有选择品牌', '', 1);
        }
        if (empty($category_name)) {
            $this->error('种类不能为空', '', 1);
        }
        if ($category_id) {
            // update
            $category->b_id = $type;
            $category->category_name = $category_name;
            $condition['category_id'] = $category_id;
            if ($category->where($condition)->save() !== false) {
                $this->success('编辑成功', 'categoryList', 1);
            }
        } else {
            $category->b_id = $type;
            $category->category_name = $category_name;
            $category->status = 1;
            $category->create_time = date('Y-m-d H:i:s');
            if ($category->add()) {
                $this->success('编辑成功', 'categoryList', 1);
            }
        }
    }

    public function deleteCategory() {
        $id = I('category_id');
        $delete = M('category');
        if ($delete->delete($id) !== false) {
            $this->success('删除成功');
        }
    }

    public function ajaxUploads()
    {
        try {
            $typeArr = array("jpg", "png", "gif");//允许上传文件格式
            $path = "/Public/uploads/logo/";//上传路径
            if (isset($_POST)) {
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $name_tmp = $_FILES['file']['tmp_name'];
                if (empty($name)) {
                    echo json_encode(array("error" => "您还未选择图片"));
                    exit;
                }
                $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

                if (!in_array($type, $typeArr)) {
                    echo json_encode(array("error" => "清上传jpg,png或gif类型的图片！"));
                    exit;
                }
                if ($size > (500 * 1024)) {
                    echo json_encode(array("error" => "图片大小已超过500KB！"));
                    exit;
                }

                $pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
                $pic_url = $path . $pic_name;//上传后图片路径+名称

                if (move_uploaded_file($name_tmp, WWW_PATH.$pic_url)) { //临时文件转移到目标文件夹
                    echo json_encode(array("pic" => $pic_url, "name" => $pic_name, "id" => guid()));
                } else {
                    echo json_encode(array("error" => "上传有误，清检查服务器配置！"));
                }
            }
        } catch (Exception $exp) {
            dump($exp);
        }
    }

    public function product() {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }
        $product = M('product');
        //  分页开始
        //  1 计算数据总条数
        //$count = $comment->where("status = 0")->count();
        $count = $product->count();
        //  2 实例化分页类
        $page = new \Think\Page($count, 20);
        $page->setConfig('first', '首页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //  3 分页输出
        $show = $page->show();
        $product = $product
            ->join('brand on product.b_id = brand.brand_id')
            ->join('category on product.c_id = category.category_id')
            ->where('product.status = 1')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
//        dump($product);exit;
        $this->assign('page', $show);
        $this->assign('product', $product);
        $this->display('Index/productList');
    }

    public function editProduct() {
        if (!session('?user')) {
            $this->error('请先登入', 'index', 2);
        }
        $brand = M('brand');
        $category = M('category');
        $brand = $brand->where('status = 1')->select();
        //  整理brand数组前台option要用的
        foreach ($brand as $b) {
            $brands[$b['brand_id']] = $b['brand_name'];
        }
        //  整理brand数组前台option要用的
        $category = $category->where('status = 1')->select();
        foreach ($category as $c) {
            $categorys[$c['category_id']] = $c['category_name'];
        }


        $product_id = I('product_id');
        if ($product_id) {
            $product = M('product');
            $condition['product.status'] = 1;
            $condition['product.product_id'] = $product_id;
            $product = $product
                ->join('brand on product.b_id = brand.brand_id')
                ->join('category on product.c_id = category.category_id')
                //->where('product_id = 1')
                ->where($condition)
                ->find();
//            dump($product);exit;
//            dump($product->getLastSql());exit;
        }
        $imageUrlArray = explode(',',$product['imageurl']);

//        dump($imageUrlArray);exit;
        if ($imageUrlArray[0] != '') {
            $this->assign('imageArr',$imageUrlArray);
        }
        $this->assign('brand',$brands);
        $this->assign('category',$categorys);
        $this->assign('product',$product);
        $this->display('Index/editProduct');
    }

    public function addProduct() {
        $b_id = I('b_id');
        $c_id = I('c_id');
        $product_name = I('product_name');
        $style = I('style');
        $price = I('price');
        $material = I('material');
        $weight = I('weight');
        $size = I('size');
        $width = I('width');
        $remark = I('remark');
        $shop_url= I('shop_url');
        if (!strstr($shop_url,'http')) {
            $shop_url = 'http://'.$shop_url;
        }
        $imageurl = I('imageUrl');
        $imageurl = implode(',',$imageurl);
        $checkInput = $this->checkInput();
        if(is_string($checkInput)) {
            $this->error($checkInput,'',1);
        }
        $product_id = I('product_id');
        $product = M('product');
        $product->b_id = $b_id;
        $product->c_id = $c_id;
        $product->product_name = $product_name;
        $product->style = $style;
        $product->price = $price;
        $product->material = $material;
        $product->weight = $weight;
        $product->size = $size;
        $product->width = $width;
        $product->remark = $remark;
        $product->shop_url = $shop_url;
        $product->imageurl = $imageurl;
        if ($product_id) {
            //update
            if ($_FILES['product_logo_img']['error'] == 0) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = WWW_PATH.'/Public'; // 设置附件上传根目录
                $upload->savePath = '/uploads/logo/'; // 设置附件上传（子）目录
                $upload->autoSub = false;
                // 上传文件
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    $file = $info['product_logo_img'];
                    $product->product_logo_img = '/Public' . $file['savepath'] . $file['savename'];
                }
            }
            $condition['product_id'] = $product_id;
            if ($product->where($condition)->save() !== false) {
                $this->success('编辑成功', 'product', 1);
            }
        } else {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = WWW_PATH.'/Public/uploads/'; // 设置附件上传根目录
            $upload->savePath = 'logo/'; // 设置附件上传（子）目录
            $upload->autoSub = false;
            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {
                $file = $info['product_logo_img'];
                $product->product_logo_img = '/Public/uploads/' . $file['savepath'] . $file['savename'];
            }

            $product->status = 1;
            $product->create_time = date('Y-m-d H:i:s');
            if ($product->add()) {
                $this->success('编辑成功', 'product', 1);
            }
        }
    }

    public function deleteProduct() {
        $id = I('product_id');
        $delete = M('product');
        if ($delete->delete($id) !== false) {
            $this->success('删除成功');
        }
    }


    private function checkInput() {
        $b_id = I('b_id');
        $c_id = I('c_id');
        $product_name = I('product_name');
        $style = I('style');
        $price = I('price');
        $material = I('material');
        $weight = I('weight');
        $size = I('size');
        $width = I('width');
        $remark = I('remark');
        $imageurl = I('imageUrl');
        if ($b_id == -1) {
            return '品牌必选';
        }
        if ($c_id == -1) {
            return '分类必选';
        }
        if (empty($product_name)) {
            return '产品名必填';
        }
        if (empty($style)) {
            return '款号必填';
        }
        if (empty($price)) {
            return '价格必填';
        }
        if (empty($material)) {
            return '材质必填';
        }
        if (empty($weight)) {
            return '重量必填';
        }
        if (empty($size)) {
            return '尺寸必填';
        }
        if (empty($width)) {
            return '戒面宽度必填';
        }
        if (!is_array($imageurl)) {
            return '产品图片必填';
        }
        return true;
    }

    public function getCategory() {
        $id = I('id');
        $category = M('category');
        $c_condition['status'] =1;
        $c_condition['b_id'] = $id;
        $category = $category->where($c_condition)->select();
        $html = '<option value="-1">未选择</option>';
        foreach ($category as $c) {
            $html .= '<option value="'.$c['category_id'].'">'.$c['category_name'].'</option>';
        }
        echo $html;
    }
}