<?php
// Stripe singleton
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Stripe.php'));

// Utilities
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/AutoPagingIterator.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/CaseInsensitiveArray.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/LoggerInterface.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/DefaultLogger.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/RandomGenerator.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/RequestOptions.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/Set.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Util/Util.php'));

// HttpClient
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/HttpClient/ClientInterface.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/HttpClient/CurlClient.php'));

// Errors
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Base.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Api.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/ApiConnection.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Authentication.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Card.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Idempotency.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/InvalidRequest.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/Permission.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/RateLimit.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/SignatureVerification.php'));

// OAuth errors
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/OAuthBase.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/InvalidClient.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/InvalidGrant.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/InvalidRequest.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/InvalidScope.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/UnsupportedGrantType.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Error/OAuth/UnsupportedResponseType.php'));

// API operations
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/All.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/Create.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/Delete.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/NestedResource.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/Request.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/Retrieve.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiOperations/Update.php'));

// Plumbing
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiResponse.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/StripeObject.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiRequestor.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApiResource.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/SingletonApiResource.php'));

// Stripe API Resources
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Account.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/AlipayAccount.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApplePayDomain.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApplicationFee.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ApplicationFeeRefund.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Balance.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/BalanceTransaction.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/BankAccount.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/BitcoinReceiver.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/BitcoinTransaction.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Card.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Charge.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Collection.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/CountrySpec.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Coupon.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Customer.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Discount.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Dispute.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/EphemeralKey.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Event.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ExchangeRate.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/File.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/FileLink.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/FileUpload.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Invoice.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/InvoiceItem.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/InvoiceLineItem.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/IssuerFraudRecord.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/Authorization.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/Card.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/CardDetails.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/Cardholder.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/Dispute.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Issuing/Transaction.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/LoginLink.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Order.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/OrderItem.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/OrderReturn.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/PaymentIntent.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Payout.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Plan.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Product.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Recipient.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/RecipientTransfer.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Refund.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Reporting/ReportRun.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Reporting/ReportType.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/SKU.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Sigma/ScheduledQueryRun.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Source.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/SourceTransaction.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Subscription.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/SubscriptionItem.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Terminal/ConnectionToken.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Terminal/Location.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Terminal/Reader.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/ThreeDSecure.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Token.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Topup.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Transfer.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/TransferReversal.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/UsageRecord.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/UsageRecordSummary.php'));

// OAuth
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/OAuth.php'));

// Webhooks
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/Webhook.php'));
require(\VQMod::modCheck(DIR_SYSTEM . 'library/stripe/WebhookSignature.php'));


class Stripe {
    
}
