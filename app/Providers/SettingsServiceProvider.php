<?php

namespace App\Providers;

use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cached settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'globalSettings' => cache()->remember('settings.global', 3600, fn () => $this->getGlobalSettings()),
                'seoSettings' => cache()->remember('settings.seo', 3600, fn () => $this->getSeoSettings()),
                'blogSettings' => cache()->remember('settings.blog', 3600, fn () => $this->getBlogSettings()),
            ]);
        });
    }

    /**
     * Get global/general settings
     */
    private function getGlobalSettings(): array
    {
        return [
            'site_name' => db_config('general.site_name', config('app.name')),
            'site_description' => db_config('general.site_description', 'Professional portfolio website'),
            'site_tagline' => db_config('general.site_tagline', ''),
            'primary_color' => db_config('general.primary_color', '#3B82F6'),
            'secondary_color' => db_config('general.secondary_color', '#8B5CF6'),
            'contact_email' => db_config('general.contact_email', 'hello@example.com'),
            'contact_phone' => db_config('general.contact_phone', ''),
            'contact_address' => db_config('general.contact_address', ''),
            'social_twitter' => db_config('general.social_twitter', ''),
            'social_linkedin' => db_config('general.social_linkedin', ''),
            'social_github' => db_config('general.social_github', ''),
            'social_instagram' => db_config('general.social_instagram', ''),
            'social_facebook' => db_config('general.social_facebook', ''),
            'social_youtube' => db_config('general.social_youtube', ''),
            'site_logo' => $this->getMedia(db_config('general.site_logo')),
            'site_logo_dark' => $this->getMedia(db_config('general.site_logo_dark')),
            'site_favicon' => $this->getMedia(db_config('general.site_favicon')),
            'profile_image' => $this->getMedia(db_config('general.profile_image')),
            'site_logo_url' => $this->getMediaUrl(db_config('general.site_logo')),
            'site_logo_dark_url' => $this->getMediaUrl(db_config('general.site_logo_dark')),
            'site_favicon_url' => $this->getMediaUrl(db_config('general.site_favicon')),
            'profile_image_url' => $this->getMediaUrl(db_config('general.profile_image')),

            // Contact page settings
            'contact_hero_title' => db_config('contact.contact_hero_title', "Let's Connect"),
            'contact_hero_subtitle' => db_config('contact.contact_hero_subtitle', 'Ready to bring your vision to life?'),
            'contact_hero_description' => db_config('contact.contact_hero_description', "I'd love to hear about your project and discuss how we can work together to create something amazing."),
            'contact_form_title' => db_config('contact.contact_form_title', 'Send me a message'),
            'contact_form_description' => db_config('contact.contact_form_description', "Fill out the form below and I'll get back to you as soon as possible."),
            'contact_name_label' => db_config('contact.contact_name_label', 'Your Name'),
            'contact_name_placeholder' => db_config('contact.contact_name_placeholder', 'John Doe'),
            'contact_email_label' => db_config('contact.contact_email_label', 'Email Address'),
            'contact_email_placeholder' => db_config('contact.contact_email_placeholder', 'john@example.com'),
            'contact_phone_label' => db_config('contact.contact_phone_label', 'Phone Number (Optional)'),
            'contact_phone_placeholder' => db_config('contact.contact_phone_placeholder', '+1 (555) 123-4567'),
            'contact_subject_label' => db_config('contact.contact_subject_label', 'Subject'),
            'contact_subject_placeholder' => db_config('contact.contact_subject_placeholder', 'Project inquiry'),
            'contact_message_label' => db_config('contact.contact_message_label', 'Message'),
            'contact_message_placeholder' => db_config('contact.contact_message_placeholder', 'Tell me about your project...'),
            'contact_submit_button' => db_config('contact.contact_submit_button', 'Send Message'),
            'contact_submitting_button' => db_config('contact.contact_submitting_button', 'Sending...'),

            // Services section
            'services_title' => db_config('contact.services_title', 'What I Can Help You With'),
            'services_description' => db_config('contact.services_description', 'Here are some of the services I offer to help bring your ideas to life.'),
            'service_1_title' => db_config('contact.service_1_title', 'Web Development'),
            'service_1_description' => db_config('contact.service_1_description', 'Custom websites and web applications built with modern technologies.'),
            'service_2_title' => db_config('contact.service_2_title', 'UI/UX Design'),
            'service_2_description' => db_config('contact.service_2_description', 'Beautiful, user-friendly designs that convert visitors into customers.'),
            'service_3_title' => db_config('contact.service_3_title', 'Consulting'),
            'service_3_description' => db_config('contact.service_3_description', 'Strategic guidance to help you make the right technology decisions.'),
            'service_4_title' => db_config('contact.service_4_title', 'Maintenance'),
            'service_4_description' => db_config('contact.service_4_description', 'Ongoing support and updates to keep your website running smoothly.'),

            // FAQ section
            'faq_title' => db_config('contact.faq_title', 'Frequently Asked Questions'),
            'faq_description' => db_config('contact.faq_description', 'Common questions about working together.'),
            'faq_1_question' => db_config('contact.faq_1_question', 'What is your typical project timeline?'),
            'faq_1_answer' => db_config('contact.faq_1_answer', "Project timelines vary depending on scope and complexity. A simple website might take 2-4 weeks, while a complex web application could take 2-3 months. I'll provide a detailed timeline after our initial consultation."),
            'faq_2_question' => db_config('contact.faq_2_question', 'How do you handle project communication?'),
            'faq_2_answer' => db_config('contact.faq_2_answer', "I believe in transparent, regular communication. We'll have weekly check-ins via your preferred method (email, Slack, or video calls), and you'll have access to a project dashboard to track progress."),
            'faq_3_question' => db_config('contact.faq_3_question', 'What is your pricing structure?'),
            'faq_3_answer' => db_config('contact.faq_3_answer', 'I offer both fixed-price projects and hourly consulting. For most projects, I prefer fixed pricing as it provides clarity for both parties. Rates vary based on project complexity and timeline.'),
            'faq_4_question' => db_config('contact.faq_4_question', 'Do you provide ongoing support?'),
            'faq_4_answer' => db_config('contact.faq_4_answer', 'Yes! I offer various support packages including bug fixes, security updates, content updates, and feature enhancements. We can discuss the best support plan for your needs.'),

            // Contact info section
            'contact_info_title' => db_config('contact.contact_info_title', 'Other Ways to Reach Me'),
            'contact_info_description' => db_config('contact.contact_info_description', 'Prefer a different way to get in touch? Here are some alternatives.'),
            'contact_email_description' => db_config('contact.contact_email_description', 'Send me an email anytime'),
            'contact_phone_description' => db_config('contact.contact_phone_description', 'Call or text me'),
            'contact_address_description' => db_config('contact.contact_address_description', 'Located in'),

            // About Page Settings
            'about_hero_title' => db_config('about.about_hero_title', 'About Me'),
            'about_hero_description' => db_config('about.about_hero_description', "I'm a passionate developer who loves creating digital experiences that make a difference. With years of experience in web development, I combine technical expertise with creative vision to build solutions that truly serve their users."),
            'about_hero_button_work' => db_config('about.about_hero_button_work', 'View My Work'),
            'about_hero_button_contact' => db_config('about.about_hero_button_contact', 'Get In Touch'),

            // Journey section
            'about_journey_title' => db_config('about.about_journey_title', 'My Journey'),
            'about_journey_paragraph_1' => db_config('about.about_journey_paragraph_1', "My journey into web development began over 5 years ago when I discovered the power of code to bring ideas to life. What started as curiosity quickly became a passion, and I've been fortunate to work on projects ranging from small business websites to complex web applications."),
            'about_journey_paragraph_2' => db_config('about.about_journey_paragraph_2', "I believe in the power of continuous learning and staying at the forefront of technology. Whether it's mastering a new framework, exploring design trends, or diving deep into user experience principles, I'm always pushing myself to grow and deliver better solutions."),
            'about_journey_paragraph_3' => db_config('about.about_journey_paragraph_3', "When I'm not coding, you'll find me exploring new technologies, contributing to open-source projects, or sharing knowledge with the developer community. I'm passionate about clean code, thoughtful design, and creating digital experiences that users truly love."),

            // Skills section
            'about_skills_title' => db_config('about.about_skills_title', 'Skills & Expertise'),
            'about_skill_1_title' => db_config('about.about_skill_1_title', 'Frontend Development'),
            'about_skill_1_description' => db_config('about.about_skill_1_description', 'Creating responsive, interactive user interfaces with modern frameworks and vanilla JavaScript.'),
            'about_skill_1_tags' => db_config('about.about_skill_1_tags', ['React', 'Vue.js', 'TypeScript', 'Tailwind CSS', 'Alpine.js']),
            'about_skill_2_title' => db_config('about.about_skill_2_title', 'Backend Development'),
            'about_skill_2_description' => db_config('about.about_skill_2_description', 'Building robust server-side applications, APIs, and database architectures.'),
            'about_skill_2_tags' => db_config('about.about_skill_2_tags', ['Laravel', 'Node.js', 'PostgreSQL', 'MySQL', 'Redis']),
            'about_skill_3_title' => db_config('about.about_skill_3_title', 'Design & UX'),
            'about_skill_3_description' => db_config('about.about_skill_3_description', 'Crafting intuitive user experiences with attention to detail and accessibility.'),
            'about_skill_3_tags' => db_config('about.about_skill_3_tags', ['Figma', 'Adobe Creative Suite', 'Prototyping', 'User Research']),

            // Values section
            'about_values_title' => db_config('about.about_values_title', 'Values That Drive Me'),
            'about_value_1_title' => db_config('about.about_value_1_title', 'Innovation'),
            'about_value_1_description' => db_config('about.about_value_1_description', 'Constantly exploring new technologies and approaches to solve problems creatively.'),
            'about_value_2_title' => db_config('about.about_value_2_title', 'Quality'),
            'about_value_2_description' => db_config('about.about_value_2_description', 'Delivering exceptional work that exceeds expectations and stands the test of time.'),
            'about_value_3_title' => db_config('about.about_value_3_title', 'Collaboration'),
            'about_value_3_description' => db_config('about.about_value_3_description', 'Working together to achieve shared goals and create meaningful impact.'),
            'about_value_4_title' => db_config('about.about_value_4_title', 'Learning'),
            'about_value_4_description' => db_config('about.about_value_4_description', 'Embracing continuous growth and staying curious about new possibilities.'),

            // CTA section
            'about_cta_title' => db_config('about.about_cta_title', 'Let\'s Create Something'),
            'about_cta_subtitle' => db_config('about.about_cta_subtitle', 'Amazing Together'),
            'about_cta_description' => db_config('about.about_cta_description', 'Ready to bring your ideas to life? I\'d love to hear about your project and explore how we can work together.'),
            'about_cta_button_contact' => db_config('about.about_cta_button_contact', 'Start a Conversation'),
            'about_cta_button_work' => db_config('about.about_cta_button_work', 'View My Work'),
        ];
    }

    /**
     * Get SEO settings
     */
    private function getSeoSettings(): array
    {
        return [
            'meta_title' => db_config('seo.meta_title', config('app.name')),
            'meta_description' => db_config('seo.meta_description', ''),
            'meta_keywords' => db_config('seo.meta_keywords', []),
            'enable_open_graph' => (bool) db_config('seo.enable_open_graph', true),
            'enable_twitter_cards' => (bool) db_config('seo.enable_twitter_cards', true),
            'enable_schema_markup' => (bool) db_config('seo.enable_schema_markup', true),
            'og_image' => db_config('seo.og_image', ''),
            'twitter_handle' => db_config('seo.twitter_handle', ''),
            'google_site_verification' => db_config('seo.google_site_verification', ''),
            'bing_site_verification' => db_config('seo.bing_site_verification', ''),
            'google_analytics_id' => db_config('seo.google_analytics_id', ''),
            'custom_head_code' => db_config('seo.custom_head_code', ''),
            'custom_body_code' => db_config('seo.custom_body_code', ''),
        ];
    }

    /**
     * Get blog settings
     */
    private function getBlogSettings(): array
    {
        return [
            'enabled' => (bool) db_config('blog.enabled', true),
            'posts_per_page' => (int) db_config('blog.posts_per_page', 10),
            'show_featured_posts' => (bool) db_config('blog.show_featured_posts', true),
            'featured_posts_count' => (int) db_config('blog.featured_posts_count', 3),
            'allow_comments' => (bool) db_config('blog.allow_comments', true),
            'moderate_comments' => (bool) db_config('blog.moderate_comments', true),
            'notify_on_comment' => (bool) db_config('blog.notify_on_comment', true),
            'show_author_bio' => (bool) db_config('blog.show_author_bio', true),
            'show_related_posts' => (bool) db_config('blog.show_related_posts', true),
            'related_posts_count' => (int) db_config('blog.related_posts_count', 3),
            'enable_tags' => (bool) db_config('blog.enable_tags', true),
            'enable_reading_time' => (bool) db_config('blog.enable_reading_time', true),
            'date_format' => db_config('blog.date_format', 'M j, Y'),
        ];
    }

    /**
     * Get media object from media ID
     */
    private function getMedia($mediaId): ?Media
    {
        if (! $mediaId) {
            return null;
        }

        return Media::find($mediaId);
    }

    /**
     * Get media URL from media ID
     */
    private function getMediaUrl($mediaId): ?string
    {
        if (! $mediaId) {
            return null;
        }

        $media = Media::find($mediaId);

        return $media ? $media->url : null;
    }
}
