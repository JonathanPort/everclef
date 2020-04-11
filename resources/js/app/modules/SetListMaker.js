import Module from './Module';
import { Sortable } from '@shopify/draggable';
import asset from './../utilities/asset';

export default class SetListMaker extends Module {

    constructor() {

        super();

        this.moduleName = 'SetListMaker';

    }


    start() {

        this.toggles = document.querySelectorAll('[data-toggle-set-list-maker]');

        if (! this.toggles.length) return;

        this.form = document.querySelector('.set-list-maker__inner');
        this.rowContainer = document.querySelector('.set-list-maker__main');
        this.nameInput = document.querySelector('.set-list-maker__name-input');

        if (! this.form || ! this.rowContainer || ! this.nameInput) {
            return super.logError('One or more missing elems.');
        }

        this.toggleClickEvent();

        super.logLoaded();

    }


    toggleClickEvent() {

        const body = document.querySelector('body');
        const openClassName = 'set-list-maker-open';

        for (let i = 0; i < this.toggles.length; i++) {

            let toggle = this.toggles[i];
            let loadData = toggle.getAttribute('data-toggle-set-list-maker');

            loadData = loadData ? JSON.parse(loadData) : false;

            toggle.addEventListener('click', () => {

                if (body.classList.contains(openClassName)) {

                    body.classList.remove(openClassName);

                    this.clearSetListMaker();

                } else {

                    if (loadData.songs.length) {
                        this.buildSetlistFromData(loadData);
                    } else {
                        this.startNewList();
                    }

                    this.updateFormHref(loadData.formHref);
                    this.addReorderEventListeners();

                    body.classList.add(openClassName);

                }

            });

        }

    }


    clearSetListMaker() {

        this.clearFormHref();
        this.rowContainer.innerHTML = '';
        this.nameInput.value = '';

    }


    updateFormHref(href) {

        this.form.action = href;

    }


    clearFormHref() {

        this.form.action = '';

    }


    buildSetlistFromData(data) {

        for (let i = 0; i < data.songs.length; i++) {
            this.rowContainer.appendChild(this.buildRow(data.songs[i], i));
        }

        this.nameInput.value = data.name ? data.name : '';

    }

    startNewList() {

        console.log('Loaded new!');

    }

    addReorderEventListeners() {

        const sortable = new Sortable(this.rowContainer, {
            draggable: '.set-list-maker__item',
            mirror: {
                // appendTo: rowContainer,
                constrainDimensions: true,
            },
        });

        // sortable.on('sortable:start', () => {});
        // sortable.on('sortable:sort', () => console.log('sortable:sort'));
        // sortable.on('sortable:sorted', () => console.log('sortable:sorted'));

        sortable.on('sortable:stop', () => {

            this.updateOrderNumbers();

        });

    }


    updateOrderNumbers() {


        // Timout to allow Draggable.js to remove mirror elements
        // before grabbing new list.
        setTimeout(() => {

            const rows = this.rowContainer.querySelectorAll('.set-list-maker__item-number');

            for (let i = 0; i < rows.length; i++) rows[i].innerHTML = `${i+1}.`;

        }, 0);

    }


    buildRow(song, i) {

        let row = document.createElement('div');
        row.classList.add('set-list-maker__item');

        let number = document.createElement('span');
        number.classList.add('set-list-maker__item-number');
        number.innerHTML = `${i+1}.`;

        let inner = document.createElement('div');
        inner.classList.add('set-list-maker__item-inner');

        let name = document.createElement('span');
        name.classList.add('set-list-maker__item-name');
        name.innerHTML = `${song.title} - ${song.artist}`;

        let reorder = document.createElement('div');
        reorder.classList.add('set-list-maker__item-reorder');

        let reorderIcon = document.createElement('img');
        reorderIcon.src = asset('images/icons/reorder-grey.png');

        let deleteBtn = document.createElement('div');
        deleteBtn.classList.add('set-list-maker__item-delete');

        let deleteIcon = document.createElement('img');
        deleteIcon.src = asset('images/icons/delete-red.png');

        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'songs[]';
        hiddenInput.value = song.id;

        reorder.appendChild(reorderIcon);
        deleteBtn.appendChild(deleteIcon);
        inner.appendChild(name);
        inner.appendChild(reorder);
        row.appendChild(number);
        row.appendChild(inner);
        row.appendChild(deleteBtn);
        row.appendChild(hiddenInput);

        this.addDeleteClickEvent(row);

        return row;

    }


    addDeleteClickEvent(row) {

        const button = row.querySelector('.set-list-maker__item-delete');

        button.addEventListener('click', () => this.rowContainer.removeChild(row));

    }

}