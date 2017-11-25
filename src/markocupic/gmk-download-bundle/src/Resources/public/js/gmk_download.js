/**
 * GmkDownload
 * @author Marko Cupic
 */
(function ($) {
    "use strict";

    $(document).ready(function () {

        var GmkDownload = {
            link: null,
            href: null,
            id: null,
            backdrop: null,
            elInput: null,
            elSubmit: null,
            elMessage: null,
            elForm: null,


            resetForm: function () {
                $(GmkDownload.elMessage).html('');
                $(GmkDownload.elInput).val('');
                $(GmkDownload.elSubmit).css('visibility', 'visible');
            },

            hideForm: function () {
                $(GmkDownload.backdrop).fadeOut();
            },

            downloadFile: function () {
                window.location.href = GmkDownload.href;
            },


            validateEmailAddress: function (emailAdress) {
                var EMAIL_REGEXP = new RegExp('^[a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,15})$', 'i');
                return EMAIL_REGEXP.test(emailAdress);
            },


            initialize: function () {


                // FadeIn overlay
                // FadeIn overlay
                $('.ce_gmk_download > a').click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();




                    // Define the vars
                    GmkDownload.link = $(this);
                    GmkDownload.href = $(GmkDownload.link).attr('href');
                    GmkDownload.id = $(GmkDownload.link).attr('data-id');
                    GmkDownload.backdrop = $('.gmk-download-modal[data-id="'+ GmkDownload.id +'"]');
                    GmkDownload.elSubmit = $(GmkDownload.backdrop).find('button.gmk-download-modal-submit-button');
                    GmkDownload.elMessage = $('.gmk-download-response-message');

                    // Insert Modal to specific place in the DOM
                    GmkDownload.backdrop.detach().insertAfter('#contentwrapper');

                    // Reset
                    GmkDownload.resetForm();
                    GmkDownload.hideForm();


                    $('.cr_button').click(function (e) {
                        e.preventDefault();
                        $(GmkDownload.elMessage).html('');

                        GmkDownload.elForm = $(this).closest('form');
                        var emailAddress = GmkDownload.backdrop.find('input[name="email"]').val();
                        if (!GmkDownload.validateEmailAddress(emailAddress)) {
                            $(GmkDownload.elMessage).html('Geben Sie bitte eine gültige E-Mail-Adresse ein.');
                            return false;
                        }

                        // E-Mail ist ok,here we go
                        // Hide submit button
                        $(GmkDownload.elSubmit).css('visibility', 'hidden');

                        // Ajax set Cookie and SESSION though the user have not to enter the email-address anymore
                        $.getJSON(window.location.href, {
                            email: emailAddress,
                            id: GmkDownload.id
                        }).done(function (data) {
                            console.log(data);
                            if (data.status == 'success') {
                                $(GmkDownload.elMessage).html(data.message);
                                window.setTimeout(function () {
                                    // aif dat-auth is false the modal want open anymore
                                    $(GmkDownload.link).attr('data-auth', 'false');
                                    // Hide form
                                    GmkDownload.elForm.css('display', 'none');

                                    // Show the download link
                                    setTimeout(function () {
                                        $('.gmk-download-modal-file-link').show();
                                    }, 2000);

                                    // Subit CleverReach form
                                    GmkDownload.elForm.submit();
                                }, 2000);
                            } else {
                                $(GmkDownload.elMessage).html(data.message);
                            }
                        });


                    });

                    // Event fadeOut
                    $('*[data-dismiss="gmk-download-modal"]').click(function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        GmkDownload.resetForm();
                        GmkDownload.hideForm();
                    });

                    $('.gmk-download-modal-dialog').click(function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });

                    // If the user has authenticated already, send file to browser
                    if ($(GmkDownload.link).attr('data-auth') == 'false') {
                        window.location.href = GmkDownload.href;
                        return;
                    } else {
                        // If user has to authenticate...
                        $(GmkDownload.backdrop).fadeIn();
                    }

                });
            }
        };

        // Initialize
        GmkDownload.initialize();
    });
})(jQuery);
