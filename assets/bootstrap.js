import { startStimulusApp } from '@symfony/stimulus-bridge';
import '@symfony/autoimport';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context('./controllers', true, /\.(j|t)sx?$/));

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
