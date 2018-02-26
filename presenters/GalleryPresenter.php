<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Gallery;
use Nette\Utils\Strings;


/**
 * Class GalleryPresenter
 *
 * @author  geniv
 * @package App\Presenters
 */
class GalleryPresenter extends ModulesBasePresenter
{
    /** @var Gallery @inject */
    public $galleryModel;


    /**
     * Startup.
     */
    protected function startup()
    {
        parent::startup();
    }


    /**
     * Render default.
     */
    public function renderDefault()
    {
        $this['breadCrumb']->addLink('breadcrumb-gallery', null, 'fa fa-picture-o');

        $this->template->gallery = $this->galleryModel->getList();

//        $this->galleryModel->getListWithFirstItem();
//        $this->galleryModel->getListItemsByIdent('gallery1');
//        $this->galleryModel->getListItemsOnHomepage();
//        $a = $this->galleryModel->getListItemsOnHomepage('gallery1');

//        $this->template->galleryItems = function ($idGallery) {
//            return $this->galleryModel->getListItems($idGallery);
//        };
    }


    /**
     * Render detail.
     *
     * @param $id
     * @throws \Nette\Application\AbortException
     */
    public function renderDetail($id)
    {
        $this['breadCrumb']->addLink('breadcrumb-gallery', '//:Gallery:', 'fa fa-picture-o');

        $detail = $this->galleryModel->getDetail($id);
        if ($detail) {
            $this['breadCrumb']->addLink('breadcrumb-gallery-' . Strings::webalize($detail->name), null, 'fa fa-picture-o');

            $this->template->detail = $detail;
            $this->template->items = $this->galleryModel->getListItems($id);
        } else {
            $this->redirect('Gallery:');
        }
    }
}
