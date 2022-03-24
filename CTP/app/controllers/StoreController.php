<?php
namespace controllers;

use models\Product;
use models\Section;
use Ubiquity\attributes\items\di\Autowired;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\core\postinstall\Display;
use Ubiquity\log\Logger;
use Ubiquity\orm\DAO;
use Ubiquity\orm\repositories\Repository;
use Ubiquity\orm\repositories\ViewRepository;
use Ubiquity\themes\ThemesManager;
use Ubiquity\utils\http\USession;
use Ubiquity\views\View;
use Ubiquity\utils\http\UResponse;


/**
 * Controller IndexController
 */
class StoreController extends ControllerBase {

    use WithAuthTrait;
    private ViewRepository $repo;


    public function initialize()
    {
        $this->view->setVar('nombre', 0);
        parent::initialize();
        $this->repo??=new ViewRepository($this, Section::class);

    }


    #[Route('default_', name: 'Home')]
    public function index(){
        $user=$this->getAuthController()->_getActiveUser();
        $this->repo->byId(USession::get('name'));

        $count=DAO::count(Product::class).' produits';
        $countSection=DAO::uCount(Section::class);
        $this->repo->all("", ['products']);
        $this->loadView("StoreController/index.html", ['user' => $user,'countProd' => $count, 'countSec' => $countSection]);
    }

    #[Get(path: "StoreController/store/section/{id}", name: "store.section")]
    public function getSection($id){
        $this->repo->byId($id,['products']);

        $this->loadView("StoreController/getSection.html");
    }

	#[Route(path: "/store/allProducts",name: "store.getAllProducts")]
	public function getAllProducts(){

        $count=DAO::count(Product::class).' produits';
        $products = DAO::getAll((Product::class));
        $this->loadView("StoreController/getAllProd.html", \compact('products', 'count'));
	}

    #[Route(path: "/store/addToCart/{price}", name:'store.addToCart')]
    public function addToCart($price){
        USession::set("price",USession::get("price")+$price);
        USession::set("quant",USession::get("quant")+1);

        UResponse::header('location', '/store/allProducts/');
    }


    protected function getAuthController(): AuthController
    {
        return new MyAuth();
    }
}
