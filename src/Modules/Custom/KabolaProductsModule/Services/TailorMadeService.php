<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Services;

use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\KabolaProductRequestRepository;

/**
 * Class TailorMadeService
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Services
 */
class TailorMadeService
{
    /**
     * @var KabolaProductRequestRepository
     */
    protected $repository;

    /**
     * TailorMadeService constructor.
     *
     * @param KabolaProductRequestRepository $repository
     */
    public function __construct(KabolaProductRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $mail
     * @param $phone
     */
    public function send($mail, $phone)
    {
        $data = array_merge($this->getDataFromSession(), ['mail' => $mail, 'phone' => $phone]);
        $this->storeRequest($mail, $phone);

        \Mail::send('email.tailor_made', $data
            , function ($m) use ($mail) {
                $m->from($mail, $mail);
                $m->to('info@kabola.nl', 'Kabola')->subject("Op maat gemaakt verzoek");
            });
    }

    /**
     * @return mixed
     */
    protected function getDataFromSession()
    {
        $data = \Session::get('product_filter');

        $data_cleaned = [
            'selected_products' => FilterAdapter::transformProductOptions(array_get($data, 'product_options', [])),
            'water_capacity'    => FilterAdapter::transformWaterCb(array_get($data, 'water_db', [])),
            'capacity'          => FilterAdapter::transformCapacity(array_get($data, 'capacity', [])),
            'efficiency'        => FilterAdapter::transformEfficiency(array_get($data, 'efficiency', [])),
        ];

        return $data_cleaned;
    }

    /**
     * @param $mail
     * @param $phone
     */
    protected function storeRequest($mail, $phone)
    {
        $this->repository->create([
            'email'   => $mail,
            'phone'   => $phone,
            'message' => ThemeView::getAdminView('email.tailor_made', array_merge($this->getDataFromSession(), ['mail' => $mail, 'phone' => $phone]))->render(),
        ]);

    }
}