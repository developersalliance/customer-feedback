define([
    'Magento_Ui/js/grid/columns/select'
], function (Select) {
    'use strict';

    return Select.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html'
        },

        getLabel: function (record) {
            var value = this._super();
            var displayValue = parseInt(value) === 1 ? 'Yes' : 'No';
            return displayValue;
        }

    });
});
