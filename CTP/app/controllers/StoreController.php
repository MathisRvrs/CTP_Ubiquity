<?php
namespace controllers;

use models\Product;
use models\Section;
use Ubiquity\attributes\items\di\Autowired;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\core\postinstall\Display;
use Ubiquity\log\Logger;
use Ubiquity\orm\DAO;
use Ubiquity\orm\repositories\Repository;
use Ubiquity\orm\repositories\ViewRepository;
use Ubiquity\themes\ThemesManager;
use Ubiquity\utils\http\USession;
use Ubiquity\views\View;

/**
 * Controller IndexController
 */
class StoreController extends ControllerBase {
    private ViewRepository $repo;

    public function initialize()
    {
        $this->view->setVar('nombre', 0);
        parent::initialize();
        $this->repo??=new ViewRepository($this, Section::class);

    }


    #[Route('default_', name: 'Home')]
    public function index(){
        $count=DAO::count(Product::class).' produits';
        $countSection=DAO::uCount(Section::class);
        $this->repo->all("", ['products']);
        $this->loadView("StoreController/index.html", ['countProd' => $count, 'countSec' => $countSection]);
    }

    #[Get(path: "StoreController/store/section/{id}", name: "store.section")]
    public function getSection($id){
        $this->repo->byId($id,['products']);

        $this->loadView("StoreController/getSection.html");
    }


	#[Route(path: "store/addToCart/{productId}/{count}",name: "store.addToCart")]
	public function addToCart($productId,$count){

        $id = USession::get($productId);
	}

}
