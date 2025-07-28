<div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filtersModalLabel">{{__('theme.filters')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row row-category-list modal-body">
                <div class="col-theme-filters-modal">
                    @include('frontend.v1.pages.brand.parts.brand-filter-form-modal')
                </div>
            </div>
        </div>
    </div>
</div>