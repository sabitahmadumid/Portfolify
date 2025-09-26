<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tables needed for our portfolio blog:
        // - users (auth)
        // - cache, cache_locks (Laravel caching)  
        // - jobs, job_batches, failed_jobs (Laravel queues)
        // - sessions (session management)
        // - password_reset_tokens (auth)
        // - settings (app settings)
        // - permissions, roles, model_has_permissions, model_has_roles, role_has_permissions (Spatie permissions)
        // - curator (Filament Curator media management - the correct one)
        // - categories, posts, comments, pages, portfolios (our blog content)
        // - migrations (Laravel system)

        // Drop the redundant media table (we'll use curator table instead)
        Schema::dropIfExists('media');

        // List of tables to drop (keeping only essential ones for portfolio blog)
        $tablesToDrop = [
            // E-commerce and marketplace tables
            'accounts', 'banners', 'envato_licenses', 'exports', 'failed_import_rows', 'imports', 
            'license_codes', 'notices', 'notifications', 'orders', 'payment_gateways', 'payment_logs', 
            'payments', 'plans', 'products', 'subscribers', 'subscription_emails', 'subscriptions', 
            'transactions', 'transfers', 'typables', 'types', 'types_metas', 'wallets',
            
            // Affiliate and business tables
            'affiliate', 'assistant', 'assistant_data_unit', 'category', 'coupon', 'data_unit', 
            'file', 'library_item', 'message', 'message_library_item', 'migration', 'option', 
            'order', 'payout', 'plan', 'plan_snapshot', 'preset', 'stat', 'subscription', 
            'user', 'voice', 'workspace', 'workspace_invitation', 'workspace_user',
            
            // Auth and access control (keep what we need, drop extras)
            'personal_access_tokens', 'clients', 'domains',
            
            // Server and hosting management
            'servers', 'services', 'coupons', 'envato_files',
            
            // Pulse (Laravel monitoring - can be re-added later if needed)
            'pulse_aggregates', 'pulse_entries', 'pulse_values',
            
            // Other miscellaneous tables
            'sliders', 'attribute_value_variant', 'attribute_values', 'attributes',
            
            // CMS and page builder tables (using our own pages table)
            'onix_blocks', 'onix_pages', 'onix_settings', 'variants', 'activity_log',
            
            // Lunar e-commerce (entire suite - not needed for blog)
            'lunar_addresses', 'lunar_assets', 'lunar_attributables', 'lunar_attribute_groups', 
            'lunar_attributes', 'lunar_brand_collection', 'lunar_brand_discount', 'lunar_brands', 
            'lunar_cart_addresses', 'lunar_cart_line_discount', 'lunar_cart_lines', 'lunar_carts', 
            'lunar_channelables', 'lunar_channels', 'lunar_collection_customer_group', 
            'lunar_collection_discount', 'lunar_collection_groups', 'lunar_collection_product', 
            'lunar_collections', 'lunar_countries', 'lunar_country_shipping_zone', 'lunar_currencies', 
            'lunar_customer_customer_group', 'lunar_customer_group_discount', 'lunar_customer_group_product', 
            'lunar_customer_group_shipping_method', 'lunar_customer_groups', 'lunar_customer_user', 
            'lunar_customers', 'lunar_discount_purchasables', 'lunar_discount_user', 'lunar_discounts', 
            'lunar_exclusion_list_shipping_zone', 'lunar_languages', 'lunar_media_product_variant', 
            'lunar_order_addresses', 'lunar_order_lines', 'lunar_order_shipping_zone', 'lunar_orders', 
            'lunar_prices', 'lunar_product_associations', 'lunar_product_option_value_product_variant', 
            'lunar_product_option_values', 'lunar_product_options', 'lunar_product_product_option', 
            'lunar_product_types', 'lunar_product_variants', 'lunar_products', 'lunar_shipping_exclusion_lists', 
            'lunar_shipping_exclusions', 'lunar_shipping_methods', 'lunar_shipping_rates', 
            'lunar_shipping_zone_postcodes', 'lunar_shipping_zones', 'lunar_staff', 'lunar_state_shipping_zone', 
            'lunar_states', 'lunar_taggables', 'lunar_tags', 'lunar_tax_classes', 'lunar_tax_rate_amounts', 
            'lunar_tax_rates', 'lunar_tax_zone_countries', 'lunar_tax_zone_customer_groups', 
            'lunar_tax_zone_postcodes', 'lunar_tax_zone_states', 'lunar_tax_zones', 'lunar_transactions', 
            'lunar_urls',
            
            // Admin and management systems
            'admin_roles', 'admins', 'branches', 'business_settings', 'category_discounts', 
            'category_searched_by_user', 'conversations', 'currencies', 'customer_addresses', 
            'd_m_reviews', 'dc_conversations', 'delivery_histories', 'delivery_men', 'email_verifications', 
            'favorite_products', 'flash_deal_products', 'flash_deals', 'loyalty_transactions', 'messages', 
            'newsletters', 'oauth_access_tokens', 'oauth_auth_codes', 'oauth_clients', 
            'oauth_personal_access_clients', 'oauth_refresh_tokens', 'order_delivery_histories', 
            'order_details', 'password_resets', 'phone_verifications', 'product_searched_by_user', 
            'product_tag', 'recent_searches', 'reviews', 'searched_categories', 'searched_data', 
            'searched_keyword_counts', 'searched_keyword_users', 'searched_products', 'social_medias', 
            'soft_credentials', 'tags', 'time_slots', 'track_deliverymen', 'translations', 
            'visited_products', 'wallet_transactions', 'wishlists',
            
            // Product and media management (duplicates)
            'media_product', 'product_categories', 'product_variations',
            
            // Various other service tables
            'account_deletion_reqs', 'activity', 'ads', 'advanced_features_section', 'advertis', 
            'ai_chat_model_plans', 'app_settings', 'article_wizard', 'bad_words', 'banner_bottom_texts', 
            'blogs', 'chat_category', 'chatbot', 'chatbot_data', 'chatbot_data_vectors', 'chatbot_history', 
            'companies', 'comparison_section_items', 'coupon_users', 'custom_biling_plans', 'customsettings', 
            'elevenlab_voices', 'email_templates', 'engines', 'entities', 'extensions', 'faq', 
            'favourite_list', 'features_marquees', 'folders', 'footer_items', 'frontend_footer_settings', 
            'frontend_future', 'frontend_generators', 'frontend_sections_statuses_titles', 'frontend_tools', 
            'frontend_who_is_for', 'gateway_taxes', 'gatewayproducts', 'gateways', 'health_check_result_history_items', 
            'howitworks', 'integrations', 'introductions', 'menus', 'oldgatewayproducts', 'openai', 
            'openai_chat_category', 'openai_filters', 'payment_proofs', 'paystack_payment_infos', 'pdf_data', 
            'pebblely', 'photo_studios', 'privacy_terms', 'prompt_library', 'rate_limits', 'revenuecat_products', 
            'settings_two', 'share_links', 'social_media_accounts', 'subscription_items', 'subscriptions_yokassa', 
            'team_members', 'teams', 'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring', 
            'testimonials', 'tokens', 'usage', 'user_affiliates', 'user_credits', 'user_docs_favorite', 
            'user_favorites', 'user_integrations', 'user_openai', 'user_openai_chat', 'user_openai_chat_messages', 
            'user_orders', 'user_support', 'user_support_messages', 'users_activity', 'webhookhistory',
            
            // More duplicates and services
            'blog_categories', 'brands', 'contact_messages', 'custom_domains', 'form_builders', 'languages', 
            'media_uploaders', 'meta_infos', 'page_builders', 'page_views', 'plan_features', 'price_plans', 
            'service_categories', 'static_option_centrals', 'static_option_twos', 'static_options', 
            'support_departments', 'support_ticket_messages', 'support_tickets', 'tenant_activity_log', 
            'tenants', 'themes',
            
            // License and billing management
            'black_lists', 'buyers', 'cpanel_latests', 'cpanel_versions', 'invoices', 'level_reseller_options', 
            'level_resellers', 'licenses', 'proxies', 'proxy_software', 'redeems', 'resellers', 'software', 
            'tickets', 'virtual_servers', 'white_lists',
            
            // Translation tools
            'ltu_contributors', 'ltu_invites', 'ltu_languages', 'ltu_phrases', 'ltu_translation_files', 'ltu_translations',
            
            // Client management and invoicing
            'affiliates', 'audit_logs', 'audit_logs_base', 'client_notes', 'connected_accounts', 'credits', 
            'customers', 'discounts', 'file_shares', 'files', 'hosting_accounts', 'hosting_servers', 
            'invoice_disputes', 'invoice_items', 'invoice_templates', 'late_fee_configurations', 'payment_histories', 
            'payment_plans', 'product_types', 'products_services', 'recurring_billing_configurations', 
            'reminder_settings', 'reports', 'saved_searches', 'site_settings', 'subscription_plans', 
            'tax_exemptions', 'tax_rates', 'team_invitations', 'team_user', 'ticket_responses', 'usage_records',
            
            // SKU and attribute management
            'attribute_option_sku', 'attribute_options', 'skus',
            
            // SMS and communication services
            'actions', 'ai_keys', 'ai_plugins', 'campaigns', 'commissions', 'contacts', 'deleted', 'devices', 
            'events', 'groups', 'keys', 'marketing', 'packages', 'payouts', 'plugins', 'quota', 'received', 
            'scheduled', 'sent', 'shorteners', 'templates', 'unsubscribed', 'ussd', 'utilities', 'visitors', 
            'vouchers', 'wa_accounts', 'wa_campaigns', 'wa_groups', 'wa_received', 'wa_scheduled', 'wa_sent', 
            'wa_servers', 'webhooks',
            
            // Restaurant and delivery management
            'account_transactions', 'add_ons', 'admin_features', 'admin_special_criterias', 'admin_testimonials', 
            'admin_wallets', 'campaign_restaurant', 'cuisine_restaurant', 'cuisines', 'data_settings', 
            'delivery_man_wallets', 'employee_roles', 'expenses', 'food', 'food_tag', 'incentive_logs', 
            'incentives', 'item_campaigns', 'logs', 'loyalty_point_transactions', 'mail_configs', 
            'notification_messages', 'order_cancel_reasons', 'order_payments', 'order_transactions', 
            'provide_d_m_earnings', 'react_promotional_banners', 'react_services', 'refund_reasons', 'refunds', 
            'restaurant_schedule', 'restaurant_subscriptions', 'restaurant_wallets', 'restaurant_zone', 
            'restaurants', 'shifts', 'social_media', 'subscription_logs', 'subscription_packages', 
            'subscription_pauses', 'subscription_schedules', 'subscription_transactions', 'time_logs', 
            'user_infos', 'user_notifications', 'vehicles', 'vendor_employees', 'vendors', 'visitor_logs', 
            'wallet_bonuses', 'wallet_payments', 'withdraw_requests', 'withdrawal_methods', 'zones',
            
            // Support and chat systems
            'sb_articles', 'sb_conversations', 'sb_messages', 'sb_reports', 'sb_settings', 'sb_users', 'sb_users_data'
        ];

        // Drop tables in batches to avoid memory issues
        $batchSize = 50;
        $batches = array_chunk($tablesToDrop, $batchSize);
        
        foreach ($batches as $batch) {
            foreach ($batch as $table) {
                if (Schema::hasTable($table)) {
                    Schema::dropIfExists($table);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't reverse this migration as it's a cleanup operation
        // If you need these tables back, restore from backup
    }
};
