<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            // General Settings
            ['key' => 'general.site_name', 'value' => 'Portfolify'],
            ['key' => 'general.site_description', 'value' => 'Professional portfolio website showcasing creative work and insights'],
            ['key' => 'general.site_tagline', 'value' => 'Creating Digital Experiences That Inspire'],
            ['key' => 'general.primary_color', 'value' => '#3B82F6'],
            ['key' => 'general.secondary_color', 'value' => '#8B5CF6'],
            ['key' => 'general.contact_email', 'value' => 'hello@portfolify.com'],
            ['key' => 'general.contact_phone', 'value' => '+1 (555) 123-4567'],
            ['key' => 'general.contact_address', 'value' => 'San Francisco, CA'],
            ['key' => 'general.social_facebook', 'value' => 'https://facebook.com/portfolify'],
            ['key' => 'general.social_twitter', 'value' => 'https://twitter.com/portfolify'],
            ['key' => 'general.social_linkedin', 'value' => 'https://linkedin.com/in/portfolify'],
            ['key' => 'general.social_instagram', 'value' => 'https://instagram.com/portfolify'],
            ['key' => 'general.social_github', 'value' => 'https://github.com/portfolify'],
            ['key' => 'general.social_youtube', 'value' => 'https://youtube.com/portfolify'],

            // Blog Settings
            ['key' => 'blog.enabled', 'value' => true],
            ['key' => 'blog.posts_per_page', 'value' => 10],
            ['key' => 'blog.show_featured_posts', 'value' => true],
            ['key' => 'blog.featured_posts_count', 'value' => 3],
            ['key' => 'blog.allow_comments', 'value' => true],
            ['key' => 'blog.moderate_comments', 'value' => true],
            ['key' => 'blog.show_author_bio', 'value' => true],
            ['key' => 'blog.enable_reading_time', 'value' => true],
            ['key' => 'blog.date_format', 'value' => 'M j, Y'],
            ['key' => 'blog.show_related_posts', 'value' => true],
            ['key' => 'blog.related_posts_count', 'value' => 3],
            ['key' => 'blog.enable_tags', 'value' => true],
            ['key' => 'blog.enable_categories', 'value' => true],
            ['key' => 'blog.comment_system', 'value' => 'built-in'],
            ['key' => 'blog.notify_on_comment', 'value' => true],
            ['key' => 'blog.excerpt_length', 'value' => 150],
            ['key' => 'blog.enable_rss', 'value' => true],
            ['key' => 'blog.enable_sitemap', 'value' => true],

            // SEO Settings
            ['key' => 'seo.meta_title', 'value' => 'Portfolify - Modern Portfolio & Blog'],
            ['key' => 'seo.meta_description', 'value' => 'Professional portfolio website showcasing creative work and insights'],
            ['key' => 'seo.meta_keywords', 'value' => ['portfolio', 'web development', 'design', 'creative', 'blog']],
            ['key' => 'seo.enable_open_graph', 'value' => true],
            ['key' => 'seo.enable_twitter_cards', 'value' => true],
            ['key' => 'seo.enable_schema_markup', 'value' => true],
            ['key' => 'seo.og_image', 'value' => ''],
            ['key' => 'seo.twitter_handle', 'value' => '@portfolify'],
            ['key' => 'seo.google_site_verification', 'value' => ''],
            ['key' => 'seo.bing_site_verification', 'value' => ''],
            ['key' => 'seo.google_analytics_id', 'value' => ''],
            ['key' => 'seo.custom_head_code', 'value' => ''],
            ['key' => 'seo.custom_body_code', 'value' => ''],

            // Footer Settings
            ['key' => 'footer.brand_name', 'value' => 'Portfolify'],
            ['key' => 'footer.brand_description', 'value' => 'Creating digital experiences that inspire and connect. Passionate about design, technology, and storytelling.'],
            ['key' => 'footer.show_brand_logo', 'value' => true],
            ['key' => 'footer.brand_logo_letter', 'value' => 'P'],
            ['key' => 'footer.copyright_text', 'value' => 'All rights reserved. Built with ❤️ using Laravel & Tailwind CSS.'],
            ['key' => 'footer.show_copyright_year', 'value' => true],
            
            // Footer Quick Links
            ['key' => 'footer.show_quick_links', 'value' => true],
            ['key' => 'footer.quick_links_title', 'value' => 'Quick Links'],
            ['key' => 'footer.quick_links', 'value' => [
                ['label' => 'Home', 'url' => 'home', 'type' => 'route'],
                ['label' => 'Portfolio', 'url' => 'portfolio.index', 'type' => 'route'],
                ['label' => 'Blog', 'url' => 'blog.index', 'type' => 'route'],
                ['label' => 'About', 'url' => 'about', 'type' => 'route'],
                ['label' => 'Contact', 'url' => 'contact', 'type' => 'route'],
            ]],
            
            // Footer Social Links
            ['key' => 'footer.show_social_links', 'value' => true],
            ['key' => 'footer.social_links_title', 'value' => 'Connect'],
            ['key' => 'footer.social_twitter_show', 'value' => true],
            ['key' => 'footer.social_linkedin_show', 'value' => true],
            ['key' => 'footer.social_github_show', 'value' => true],
            ['key' => 'footer.social_instagram_show', 'value' => false],
            ['key' => 'footer.social_facebook_show', 'value' => false],
            ['key' => 'footer.social_youtube_show', 'value' => false],
            
            // Footer Layout
            ['key' => 'footer.layout_columns', 'value' => 'grid-cols-1 md:grid-cols-4'],
            ['key' => 'footer.brand_column_span', 'value' => 'md:col-span-2'],
            ['key' => 'footer.background_style', 'value' => 'bg-gray-50 dark:bg-gray-900'],
            ['key' => 'footer.border_style', 'value' => 'border-t border-gray-200 dark:border-gray-800'],
            ['key' => 'footer.text_color', 'value' => 'text-gray-600 dark:text-gray-400'],
        ];

        // Contact Page Settings
        $contactSettings = [
            ['key' => 'contact.contact_hero_title', 'value' => "Let's Connect"],
            ['key' => 'contact.contact_hero_subtitle', 'value' => 'Ready to bring your vision to life?'],
            ['key' => 'contact.contact_hero_description', 'value' => "I'd love to hear about your project and discuss how we can work together to create something amazing."],
            ['key' => 'contact.contact_form_title', 'value' => 'Send me a message'],
            ['key' => 'contact.contact_form_description', 'value' => "Fill out the form below and I'll get back to you as soon as possible."],
            ['key' => 'contact.contact_name_label', 'value' => 'Your Name'],
            ['key' => 'contact.contact_name_placeholder', 'value' => 'John Doe'],
            ['key' => 'contact.contact_email_label', 'value' => 'Email Address'],
            ['key' => 'contact.contact_email_placeholder', 'value' => 'john@example.com'],
            ['key' => 'contact.contact_phone_label', 'value' => 'Phone Number (Optional)'],
            ['key' => 'contact.contact_phone_placeholder', 'value' => '+1 (555) 123-4567'],
            ['key' => 'contact.contact_subject_label', 'value' => 'Subject'],
            ['key' => 'contact.contact_subject_placeholder', 'value' => 'Project inquiry'],
            ['key' => 'contact.contact_message_label', 'value' => 'Message'],
            ['key' => 'contact.contact_message_placeholder', 'value' => 'Tell me about your project...'],
            ['key' => 'contact.contact_submit_button', 'value' => 'Send Message'],
            ['key' => 'contact.contact_submitting_button', 'value' => 'Sending...'],
            ['key' => 'contact.services_title', 'value' => 'What I Can Help You With'],
            ['key' => 'contact.services_description', 'value' => 'Here are some of the services I offer to help bring your ideas to life.'],
            ['key' => 'contact.service_1_title', 'value' => 'Web Development'],
            ['key' => 'contact.service_1_description', 'value' => 'Custom websites and web applications built with modern technologies.'],
            ['key' => 'contact.service_2_title', 'value' => 'UI/UX Design'],
            ['key' => 'contact.service_2_description', 'value' => 'Beautiful, user-friendly designs that convert visitors into customers.'],
            ['key' => 'contact.service_3_title', 'value' => 'Consulting'],
            ['key' => 'contact.service_3_description', 'value' => 'Strategic guidance to help you make the right technology decisions.'],
            ['key' => 'contact.service_4_title', 'value' => 'Maintenance'],
            ['key' => 'contact.service_4_description', 'value' => 'Ongoing support and updates to keep your website running smoothly.'],
            ['key' => 'contact.faq_title', 'value' => 'Frequently Asked Questions'],
            ['key' => 'contact.faq_description', 'value' => 'Common questions about working together.'],
            ['key' => 'contact.faq_1_question', 'value' => 'What is your typical project timeline?'],
            ['key' => 'contact.faq_1_answer', 'value' => "Project timelines vary depending on scope and complexity. A simple website might take 2-4 weeks, while a complex web application could take 2-3 months. I'll provide a detailed timeline after our initial consultation."],
            ['key' => 'contact.faq_2_question', 'value' => 'How do you handle project communication?'],
            ['key' => 'contact.faq_2_answer', 'value' => "I believe in transparent, regular communication. We'll have weekly check-ins via your preferred method (email, Slack, or video calls), and you'll have access to a project dashboard to track progress."],
            ['key' => 'contact.faq_3_question', 'value' => 'What is your pricing structure?'],
            ['key' => 'contact.faq_3_answer', 'value' => 'I offer both fixed-price projects and hourly consulting. For most projects, I prefer fixed pricing as it provides clarity for both parties. Rates vary based on project complexity and timeline.'],
            ['key' => 'contact.faq_4_question', 'value' => 'Do you provide ongoing support?'],
            ['key' => 'contact.faq_4_answer', 'value' => 'Yes! I offer various support packages including bug fixes, security updates, content updates, and feature enhancements. We can discuss the best support plan for your needs.'],
            ['key' => 'contact.contact_info_title', 'value' => 'Other Ways to Reach Me'],
            ['key' => 'contact.contact_info_description', 'value' => 'Prefer a different way to get in touch? Here are some alternatives.'],
            ['key' => 'contact.contact_email_description', 'value' => 'Send me an email anytime'],
            ['key' => 'contact.contact_phone_description', 'value' => 'Call or text me'],
            ['key' => 'contact.contact_address_description', 'value' => 'Located in'],
        ];

        // About Page Settings
        $aboutSettings = [
            ['key' => 'about.about_hero_title', 'value' => 'About Me'],
            ['key' => 'about.about_hero_description', 'value' => "I'm a passionate developer who loves creating digital experiences that make a difference. With years of experience in web development, I combine technical expertise with creative vision to build solutions that truly serve their users."],
            ['key' => 'about.about_hero_button_work', 'value' => 'View My Work'],
            ['key' => 'about.about_hero_button_contact', 'value' => 'Get In Touch'],
            ['key' => 'about.about_journey_title', 'value' => 'My Journey'],
            ['key' => 'about.about_journey_paragraph_1', 'value' => "My journey into web development began over 5 years ago when I discovered the power of code to bring ideas to life. What started as curiosity quickly became a passion, and I've been fortunate to work on projects ranging from small business websites to complex web applications."],
            ['key' => 'about.about_journey_paragraph_2', 'value' => "I believe in the power of continuous learning and staying at the forefront of technology. Whether it's mastering a new framework, exploring design trends, or diving deep into user experience principles, I'm always pushing myself to grow and deliver better solutions."],
            ['key' => 'about.about_journey_paragraph_3', 'value' => "When I'm not coding, you'll find me exploring new technologies, contributing to open-source projects, or sharing knowledge with the developer community. I'm passionate about clean code, thoughtful design, and creating digital experiences that users truly love."],
            ['key' => 'about.about_skills_title', 'value' => 'Skills & Expertise'],
            ['key' => 'about.about_skill_1_title', 'value' => 'Frontend Development'],
            ['key' => 'about.about_skill_1_description', 'value' => 'Creating responsive, interactive user interfaces with modern frameworks and vanilla JavaScript.'],
            ['key' => 'about.about_skill_1_tags', 'value' => ['React', 'Vue.js', 'TypeScript', 'Tailwind CSS', 'Alpine.js']],
            ['key' => 'about.about_skill_2_title', 'value' => 'Backend Development'],
            ['key' => 'about.about_skill_2_description', 'value' => 'Building robust server-side applications, APIs, and database architectures.'],
            ['key' => 'about.about_skill_2_tags', 'value' => ['Laravel', 'Node.js', 'PostgreSQL', 'MySQL', 'Redis']],
            ['key' => 'about.about_skill_3_title', 'value' => 'Design & UX'],
            ['key' => 'about.about_skill_3_description', 'value' => 'Crafting intuitive user experiences with attention to detail and accessibility.'],
            ['key' => 'about.about_skill_3_tags', 'value' => ['Figma', 'Adobe Creative Suite', 'Prototyping', 'User Research']],
            ['key' => 'about.about_values_title', 'value' => 'Values That Drive Me'],
            ['key' => 'about.about_value_1_title', 'value' => 'Innovation'],
            ['key' => 'about.about_value_1_description', 'value' => 'Constantly exploring new technologies and approaches to solve problems creatively.'],
            ['key' => 'about.about_value_2_title', 'value' => 'Quality'],
            ['key' => 'about.about_value_2_description', 'value' => 'Delivering exceptional work that exceeds expectations and stands the test of time.'],
            ['key' => 'about.about_value_3_title', 'value' => 'Collaboration'],
            ['key' => 'about.about_value_3_description', 'value' => 'Working together to achieve shared goals and create meaningful impact.'],
            ['key' => 'about.about_value_4_title', 'value' => 'Learning'],
            ['key' => 'about.about_value_4_description', 'value' => 'Embracing continuous growth and staying curious about new possibilities.'],
            ['key' => 'about.about_cta_title', 'value' => "Let's Create Something"],
            ['key' => 'about.about_cta_subtitle', 'value' => 'Amazing Together'],
            ['key' => 'about.about_cta_description', 'value' => "Ready to bring your ideas to life? I'd love to hear about your project and explore how we can work together."],
            ['key' => 'about.about_cta_button_contact', 'value' => 'Start a Conversation'],
            ['key' => 'about.about_cta_button_work', 'value' => 'View My Work'],
        ];

        // Merge all configurations
        $allConfigs = array_merge($configs, $contactSettings, $aboutSettings);

        foreach ($allConfigs as $config) {
            // Extract group and key from the dot notation
            $parts = explode('.', $config['key']);
            $group = $parts[0] ?? 'general';
            $key = $parts[1] ?? $config['key'];

            DB::table('db_config')->updateOrInsert(
                ['group' => $group, 'key' => $key],
                [
                    'group' => $group,
                    'key' => $key,
                    'settings' => json_encode($config['value']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Configuration settings seeded successfully!');
        $this->command->info('Total settings seeded: '.count($allConfigs));
    }
}
