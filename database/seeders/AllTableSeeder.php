<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            ['name' => 'ルフィ',
            'image' => 'https://1.bp.blogspot.com/-tVeC6En4e_E/X96mhDTzJNI/AAAAAAABdBo/jlD_jvZvMuk3qUcNjA_XORrA4w3lhPkdQCNcBGAsYHQ/s1048/onepiece01_luffy.png',
            'birth' => '"2000-05-05"',
            'description' => '海賊王に俺はなる！！',
            'user_id' => 1],
            ['name' => 'ゾロ',
            'image' => 'https://1.bp.blogspot.com/-LSyPj8f6RT0/YAOTCLcFyjI/AAAAAAABdOE/m9HOKsxx4SkWciWD6VrcJBC-JYF-py1pACNcBGAsYHQ/s1041/onepiece02_zoro.png',
            'birth' => '"2000-11-11"',
            'description' => '背中の傷は剣士の恥だ',
            'user_id' => 2],
            ['name' => 'チョッパー',
            'image' => 'https://1.bp.blogspot.com/-IcUvUygdIYo/X-FcuSmyciI/AAAAAAABdEM/23Z600-euloEsgYlDAJeOztnWND4CjuKgCNcBGAsYHQ/s992/onepiece06_chopper2.png',
            'birth' => '"2000-12-24"',
            'description' => 'トニートニー・チョッパーです',
            'user_id' => 3],
        ]);
        DB::table('talkrooms')->insert([
            ['name' => 'トークルームA'],
            ['name' => 'トークルームB'],
            ['name' => 'トークルームC'],
        ]);
        DB::table('messages')->insert([
            ['content' => 'やあ','user_id' => 1,'talkroom_id' => 1],
            ['content' => 'おはよう','user_id' => 1,'talkroom_id' => 1],
            ['content' => 'おはようございます','user_id' => 2,'talkroom_id' => 1],
            ['content' => 'こんにちは','user_id' => 1,'talkroom_id' => 2],
            ['content' => 'こんばんは','user_id' => 2,'talkroom_id' => 3],
        ]);
        DB::table('friends')->insert([
            ['user_id' => 1, 'friend_id' => 2],
            ['user_id' => 2, 'friend_id' => 1],
            ['user_id' => 1, 'friend_id' => 3],
        ]);
        DB::table('talkroom_user')->insert([
            ['talkroom_id' => 1, 'user_id' => 1],
            ['talkroom_id' => 1, 'user_id' => 2],
            ['talkroom_id' => 2, 'user_id' => 1],
        ]);

    }
}
