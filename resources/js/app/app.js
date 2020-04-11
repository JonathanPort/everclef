import Framework from './Framework';

const Everclef = new Framework('Everclef', {
    debug: true,
    modules: [
        'Notifications',
        'TagInputs',
        'ActionMenus',
        'FilterMenus',
        'LyricsSearcher',
        'LyricsCoverflow',
        'LyricsEditor',
        'ConfirmDialogues',
        'SetListMaker'
    ],
});


Everclef.init().loadModules();
