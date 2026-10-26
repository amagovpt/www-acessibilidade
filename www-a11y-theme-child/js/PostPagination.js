class PostPagination {
    constructor() {
        this.currentPage        = 1;
        this.category           = false;
        this.tag                = false;
        this.postList           = jQuery('.post-list');
        this.paginationWrapper  = jQuery('#paginacao');
        this.init();
    }
    init() {
        this.addListeners();
    }

    handlePagination(e) {
        this.updateCurrentPage(e.currentTarget)
        let pData = this.paginationData();
        if(this.category){
            pData.category = this.category;
        }
        jQuery.ajax({
            url: AMA.ajax_url,
            type: 'post',
            data: pData,
            success: (response) =>
            {
                this.postList.html(response.data.content);
                this.paginationWrapper.html(response.data.pagination);

                window.scrollTo({
                    top: this.postList.offset().top,
                    behavior: 'smooth'
                });
                this.loadingSpinnerToggle();
                this.addListeners()
            },
            error: (msg) =>
            {
                this.postList.html('Não foi possível apresentar resultados.');
                this.paginationWrapper.html('');
                this.loadingSpinnerToggle();
            }
        });


    }

    addListeners(){
        this.getTaxonomy();
        jQuery('.page-item:not([aria-current="page"])').off().on("click", (e) => {
            e.preventDefault()
            this.loadingSpinnerToggle()
            this.handlePagination(e)
        });
    }

    updateCurrentPage(element) {

        // Check if the current element has the .next class
        if(jQuery(element).hasClass('next')) {
            this.currentPage = parseInt(this.currentPage) + 1;
        } else if(jQuery(element).hasClass('prev')) {
            this.currentPage = parseInt(this.currentPage) - 1;
        } else {
            this.currentPage = jQuery(element).attr('data-pagina');
        }
    }


    getTaxonomy() {
        let cat = jQuery('.post-list[data-categoria]');
        if(!cat.length) {
            return false;
        }
        this.category = cat.attr('data-categoria');
    }

    loadingSpinnerToggle() {
        jQuery('.loading-posts').toggleClass('show');
    }

    paginationData() {
            let formFields = {
                action:     'ama_post_pagination',
                page:       parseInt(this.currentPage)
            }

            if(this.category){
                formFields.category = this.category;
            }

            if(this.tag){
                formFields.tag = this.tag;
            }

            return formFields;
        }

}

window.onload = function() {
    let pagination = new PostPagination();
    console.log('PostPagination loaded');
    console.log(pagination);
};