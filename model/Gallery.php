<?php declare(strict_types=1);

namespace App\Model;

use Dibi\Connection;
use Dibi\Fluent;
use Dibi\Row;
use Locale\ILocale;
use Nette\DI\Container;
use Nette\SmartObject;


/**
 * Class Gallery
 *
 * @author  geniv
 * @package App\Model
 */
class Gallery
{
    use SmartObject;

    // define constant table names
    const
        TABLE_NAME = 'gallery',
        TABLE_NAME_HAS_LOCALE = 'gallery_has_locale',
        TABLE_NAME_ITEM = 'gallery_item',
        TABLE_NAME_ITEM_HAS_LOCALE = 'gallery_item_has_locale';

    /** @var string tables name */
    private $tableGallery, $tableGalleryHasLocale, $tableGalleryItem, $tableGalleryItemHasLocale;
    /** @var Connection database connection from DI */
    private $connection;
    /** @var int id locale */
    private $idLocale;


    /**
     * Gallery constructor.
     *
     * @param array      $parameters
     * @param Connection $connection
     * @param ILocale    $locale
     * @param Container  $container
     */
    public function __construct(array $parameters, Connection $connection, ILocale $locale, Container $container)
    {
        // define table names
        $this->tableGallery = $parameters['tablePrefix'] . self::TABLE_NAME;
        $this->tableGalleryHasLocale = $parameters['tablePrefix'] . self::TABLE_NAME_HAS_LOCALE;           // gallery has locale
        $this->tableGalleryItem = $parameters['tablePrefix'] . self::TABLE_NAME_ITEM;                      // gallery item
        $this->tableGalleryItemHasLocale = $parameters['tablePrefix'] . self::TABLE_NAME_ITEM_HAS_LOCALE;  // gallery item has locale

        $this->connection = $connection;
        $this->idLocale = $locale->getId();
        $container->parameters += $parameters;  // set configure from extension
    }


    /**
     * Get list.
     *
     * @return Fluent
     */
    public function getList(): Fluent
    {
        return $this->connection->select('g.id, ghl.name, ghl.description, g.added, g.visible, g.visible_on_homepage')
            ->from($this->tableGallery)->as('g')
            ->leftJoin($this->tableGalleryHasLocale)->as('ghl')->on('ghl.id_gallery=g.id')->and(['ghl.id_locale' => $this->idLocale])
            ->where(['g.visible' => true])
            ->orderBy('g.position')->asc();
    }


    /**
     * Get list with first item.
     *
     * @return Fluent
     */
    public function getListWithFirstItem(): Fluent
    {
        return $this->getList()
            ->select('gi.image, gihl.title')
            ->join($this->tableGalleryItem)->as('gi')->on('gi.id_gallery=g.id')->and('gi.visible=%i', true)
            ->leftJoin($this->tableGalleryItemHasLocale)->as('gihl')->on('gihl.id_gallery_item=gi.id')->and(['gihl.id_locale' => $this->idLocale])
            ->groupBy('g.id');
    }


    /**
     * Get detail.
     *
     * @param $idGallery
     * @return Row|false
     */
    public function getDetail($idGallery)
    {
        return $this->getList()
            ->where(['g.id' => $idGallery])
            ->fetch();
    }


    /**
     * Get items.
     *
     * @return Fluent
     */
    private function getItems(): Fluent
    {
        return $this->connection->select('gi.id, gihl.title, gi.image, gi.added, gi.visible, gi.visible_on_homepage')
            ->from($this->tableGalleryItem)->as('gi')
            ->leftJoin($this->tableGalleryItemHasLocale)->as('gihl')->on('gihl.id_gallery_item=gi.id')->and(['gihl.id_locale' => $this->idLocale]);
    }


    /**
     * Get list items.
     *
     * @param $idGallery
     * @return Fluent
     */
    public function getListItems($idGallery): Fluent
    {
        return $this->getItems()
            ->where(['gi.visible' => true, 'gi.id_gallery' => $idGallery])
            ->orderBy('gi.position')->asc();
    }


    /**
     * Get list items by ident.
     *
     * @param $ident
     * @return Fluent
     */
    public function getListItemsByIdent($ident): Fluent
    {
        return $this->getItems()
            ->join($this->tableGallery)->as('g')->on('g.id=gi.id_gallery')
            ->where(['gi.visible' => true, 'g.ident' => $ident])
            ->orderBy('gi.position')->asc();
    }


    /**
     * Get list items on homepage.
     *
     * @param null $ident
     * @return Fluent
     */
    public function getListItemsOnHomepage($ident = null): Fluent
    {
        $cursor = $this->getItems()
            ->where(['gi.visible' => true, 'gi.visible_on_homepage' => true]);

        if ($ident) {
            $cursor->join($this->tableGallery)->as('g')->on('g.id=gi.id_gallery')
                ->where('g.ident=%s', $ident);
        }
        return $cursor;
    }
}
