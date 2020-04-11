import Module from './Module';

export default class FilterMenus extends Module {

    constructor() {

        super();

        this.moduleName = 'FilterMenus';

    }

    start() {

        const menus = document.querySelectorAll('[data-filter-menu]');

        for (let i = 0; i < menus.length; i++) new FilterMenu(menus[i]);

        if (menus.length) return super.logLoaded();

    }

}

class FilterMenu {

    constructor(menu) {

        this.menu = menu;
        this.menuInner = menu.querySelector('.filter-menu__main');
        this.footer = menu.querySelector('.filter-menu__footer');
        this.applyBtn = menu.querySelector('.filter-menu__apply');
        this.uncheckAllBtn = menu.querySelector('.filter-menu__uncheck');
        this.key = menu.getAttribute('data-filter-menu');
        this.searchInput = menu.querySelector('.filter-menu__search input');

        this.menuVisibilityEvent();
        this.setOriginallyCheckedItems();
        this.itemsClickEvent();
        this.applyButtonClickEvent();
        this.uncheckAllClickEvent();
        this.searchEventListener();

    }


    searchEventListener() {

        let val;
        let rows;
        let rowText;
        let rowsToHide;
        let rowsToShow;

        let toggleVisibility = (elems, visibility) => {

            for (let i = 0; i < elems.length; i++) {

                if (visibility === 'hide') {
                    elems[i].classList.add('filter-menu__row--hidden');
                } else if (visibility === 'show') {
                    elems[i].classList.remove('filter-menu__row--hidden');
                }

            }

        };

        this.searchInput.addEventListener('keyup', () => {

            rowsToHide = [];
            rowsToShow = [];
            rows = this.menu.querySelectorAll('.filter-menu__row');
            val = this.searchInput.value.toLowerCase();

            if (! val) return toggleVisibility(rows, 'show');

            for (let i = 0; i < rows.length; i++) {

                rowText = rows[i].querySelector('.filter-menu__row-text').innerHTML.toLowerCase();

                if (! rowText.includes(val)) {
                    rowsToHide.push(rows[i]);
                } else {
                    rowsToShow.push(rows[i]);
                }

            }

            toggleVisibility(rowsToShow, 'show');
            toggleVisibility(rowsToHide, 'hide');

        });

    }


    uncheckAllClickEvent() {

        this.uncheckAllBtn.addEventListener('click', () => {

            let checkboxes = this.menu.querySelectorAll('[data-filter-menu-checkbox]');

            for (let i = 0; i < checkboxes.length; i++) checkboxes[i].checked = false;

            this.menu.classList.add('filter-menu--footer-visible');

        });

    }


    applyButtonClickEvent() {

        const url = this.menu.getAttribute('data-filter-menu-url');
        let params = JSON.parse(this.menu.getAttribute('data-filter-menu-params'));

        this.applyBtn.addEventListener('click', () => {

            let filter = this.getCheckedItems().join('|');

            params[this.key] = filter;

            window.location.href = url + '/?' + this.serializeParams(params);

        });

    }


    serializeParams(params) {

        let str = [];

        for (let p in params)

            if (params.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + '=' + encodeURIComponent(params[p]));
            }

        return str.join('&');

    }


    setOriginallyCheckedItems() {

        this.originallyCheckedItems = this.getCheckedItems();

    }


    getCheckedItems() {

        let checkboxes = this.menu.querySelectorAll('[data-filter-menu-checkbox]:checked');

        let arr = [];

        for (let i = 0; i < checkboxes.length; i++) arr.push(checkboxes[i].value);

        return arr;

    }


    itemsClickEvent() {

        let checkboxes = this.menu.querySelectorAll('[data-filter-menu-checkbox]');


        for (let i = 0; i < checkboxes.length; i++) {

            checkboxes[i].addEventListener('click', (e) => {

                this.menu.classList.add('filter-menu--footer-visible');

            });

        }

    }


    menuVisibilityEvent() {

        const toggles = document.querySelectorAll('[data-toggle-filter-menu="' + this.key + '"]');
        const filters = document.querySelector('.filters');

        for (let i = 0; i < toggles.length; i++) {

            toggles[i].addEventListener('click', () => {

                if (this.menu.classList.contains('filter-menu--open')) {
                    this.menu.classList.remove('filter-menu--open');
                    filters.classList.remove('filters--menu-open');
                } else {
                    this.menu.classList.add('filter-menu--open');
                    filters.classList.add('filters--menu-open');
                    this.setMenuPosition(toggles[i]);
                }

            });

        }

    }


    setMenuPosition(toggle) {

        let viewportOffset = toggle.getBoundingClientRect();

        let width = viewportOffset.width;
        let left = viewportOffset.left;
        let top = viewportOffset.top;

        let x = left - (width + (width / 2)) + 20;
        let y = top + 10;
        // console.log(viewportOffset);
        // this.menuInner.style.left = x + 'px';

    }


}