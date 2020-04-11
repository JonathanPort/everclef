import Module from './Module';

export default class ActionMenus extends Module {

    constructor() {

        super();

        this.moduleName = 'ActionMenus';

    }

    start() {

        const menus = document.querySelectorAll('[data-action-menu]');

        for (let i = 0; i < menus.length; i++) new ActionMenu(menus[i]);

        if (menus.length) return super.logLoaded();

    }

}

class ActionMenu {

    constructor(menu) {

        this.menu = menu;
        this.key = menu.getAttribute('data-action-menu');

        this.menuVisibilityEvent();

    }

    menuVisibilityEvent() {

        const toggles = document.querySelectorAll('[data-toggle-action-menu="' + this.key + '"]');

        for (let i = 0; i < toggles.length; i++) {

            toggles[i].addEventListener('click', () => {

                if (this.menu.classList.contains('action-menu--open')) {
                    this.menu.classList.remove('action-menu--open');
                } else {
                    this.menu.classList.add('action-menu--open');
                }

            });

        }

    }

}