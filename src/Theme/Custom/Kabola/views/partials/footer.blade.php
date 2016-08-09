<footer id="footer">
    @php
        $repo = app(\Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories\PartialsRepository::class);
        $item = $repo->getBySlugAndLocale('footer', app()->getLocale());
        if($item !== null) {
            echo $item->content;
        }
    @endphp
</footer>
