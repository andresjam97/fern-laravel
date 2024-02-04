<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE OR REPLACE VIEW leaderboard_qqsm as select leaderboard.rnk_score,
        leaderboard.id_user,
        u.name,
        leaderboard.rnk_accuracy,
        leaderboard.max_score,
        leaderboard.accuracy from (
        select
            row_number() over (order by scores.max_score desc, scores.accuracy desc) as rnk_score,
            row_number() over (order by scores.accuracy desc, scores.max_score desc) as rnk_accuracy,
            scores.id_user,
            scores.max_score,
            scores.accuracy
        from (
        select gr.id_user, gr.max_score, (gr.total_accuracy / gr.game_numbers) as accuracy from (
            select
                gq.id_user,
                sum(gq.score) as max_score,
                count(*) as game_numbers,
                sum(gq.accuracy) as total_accuracy
            from games gq
            where gq.status != 'EN JUEGO'
            group by gq.id_user) as gr
        ) as scores
    ) as leaderboard
    inner join users as u
    on u.id = leaderboard.id_user");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW leaderboard_qqsm");
    }
};
