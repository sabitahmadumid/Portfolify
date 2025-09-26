<?php

namespace App\Helpers;

class AvatarHelper
{
    private static array $colors = [
        'bg-red-500',
        'bg-blue-500',
        'bg-green-500',
        'bg-yellow-500',
        'bg-purple-500',
        'bg-pink-500',
        'bg-indigo-500',
        'bg-teal-500',
        'bg-orange-500',
        'bg-cyan-500',
        'bg-lime-500',
        'bg-emerald-500',
        'bg-violet-500',
        'bg-fuchsia-500',
        'bg-rose-500',
        'bg-sky-500',
        'bg-amber-500',
        'bg-stone-500',
        'bg-neutral-500',
        'bg-zinc-500',
    ];

    private static array $gradients = [
        'bg-gradient-to-br from-red-500 to-pink-500',
        'bg-gradient-to-br from-blue-500 to-purple-500',
        'bg-gradient-to-br from-green-500 to-teal-500',
        'bg-gradient-to-br from-yellow-500 to-orange-500',
        'bg-gradient-to-br from-purple-500 to-indigo-500',
        'bg-gradient-to-br from-pink-500 to-rose-500',
        'bg-gradient-to-br from-indigo-500 to-blue-500',
        'bg-gradient-to-br from-teal-500 to-cyan-500',
        'bg-gradient-to-br from-orange-500 to-red-500',
        'bg-gradient-to-br from-cyan-500 to-blue-500',
        'bg-gradient-to-br from-lime-500 to-green-500',
        'bg-gradient-to-br from-emerald-500 to-teal-500',
        'bg-gradient-to-br from-violet-500 to-purple-500',
        'bg-gradient-to-br from-fuchsia-500 to-pink-500',
        'bg-gradient-to-br from-rose-500 to-red-500',
        'bg-gradient-to-br from-sky-500 to-blue-500',
        'bg-gradient-to-br from-amber-500 to-yellow-500',
    ];

    public static function getInitials(string $name): string
    {
        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
                if (strlen($initials) >= 2) {
                    break;
                }
            }
        }

        return $initials ?: 'U';
    }

    public static function getColorFromEmail(string $email): string
    {
        $hash = md5(strtolower(trim($email)));
        $index = hexdec(substr($hash, 0, 2)) % count(self::$colors);
        return self::$colors[$index];
    }

    public static function getGradientFromEmail(string $email): string
    {
        $hash = md5(strtolower(trim($email)));
        $index = hexdec(substr($hash, 0, 2)) % count(self::$gradients);
        return self::$gradients[$index];
    }

    public static function getGravatarUrl(string $email, int $size = 80, string $default = 'identicon'): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default}";
    }

    public static function generateAvatar(string $name, string $email, string $type = 'gradient'): array
    {
        $initials = self::getInitials($name);
        
        return [
            'initials' => $initials,
            'color' => $type === 'gradient' ? self::getGradientFromEmail($email) : self::getColorFromEmail($email),
            'gravatar' => self::getGravatarUrl($email),
        ];
    }
}
