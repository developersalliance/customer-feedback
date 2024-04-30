define([
    'ko',
    'jquery',
    'uiComponent',
    'Magento_Ui/js/modal/alert'
], function (ko, $, Component, alert) {
    'use strict';

    return Component.extend({
        defaults: {
            title: '',
            feedback: '',
            submitAnonymously: false,
            productId: 0,
            formKey: '',
            template: 'Devall_CustomerFeedback/feedback-form',
            isFormVisible: false
        },

        initialize: function () {
            this._super();
            this.title = ko.observable(this.title);
            this.feedback = ko.observable(this.feedback);
            this.submitAnonymously = ko.observable(this.submitAnonymously);
            this.isFormVisible = ko.observable(this.isFormVisible);
            return this;
        },

        toggleForm: function() {
            this.isFormVisible(!this.isFormVisible());
        },

        submitFeedback: function () {
            if (!this.title() || !this.feedback()) {
                alert({
                    content: 'Please fill in all required fields!'
                });
                return false;
            }

            var formData = {
                feedback: {
                    title: this.title(),
                    feedback: this.feedback(),
                    product_id: this.productId,
                    anonymous: this.submitAnonymously()
                }
            };

            $.ajax({
                url: '/rest/V1/feedback/submit',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(formData),
                contentType: "application/json",
                showLoader: true,
                success: function (response) {
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            console.error("Error parsing JSON response", e);
                        }
                    }
                    alert({
                        content: response.message
                    });
                    if (response.success) {
                        this.title('');
                        this.feedback('');
                        this.submitAnonymously(false);
                    }
                }.bind(this),
                error: function (xhr) {
                    var errorMessage = 'There was an error submitting your feedback. Please try again.';
                    if (xhr.status === 401) {
                        errorMessage = 'You need to be logged in to submit feedback.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert({
                        content: errorMessage
                    });
                }
            });

            return false;
        }
    });
});