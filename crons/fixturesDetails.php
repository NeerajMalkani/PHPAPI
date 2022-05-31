<?php
$connect = new mysqli("184.168.96.211", "neerajmalkani", "secure@MySQL", "cricketdb"); //Connect PHP to MySQL Database
date_default_timezone_set('asia/kolkata');
$date = new DateTime();
$date->modify('+4 day');
$date1 = new DateTime();
$date1->modify('-4 day');
$service_url = "https://cricket.sportmonks.com/api/v2.0/fixtures?filter[starts_between]=" . $date1->format('Y-m-d') . "," . $date->format('Y-m-d') . "&include=runs,batting,bowling,scoreboards,lineup&sort=id&api_token=9zC8IKVOFPGJyGkyrGk9n1eEpSEeDIyjWqprJYO9vMZ5Yyo9HSgfmWc0y7U7";
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$fixturesList = curl_exec($curl);
curl_close($curl);
$fixturesList = json_decode($fixturesList);
$array = (array) $fixturesList->data;
$query = "";
foreach ($array as $row) {
  $ls = (is_null($row->localteam_dl_data->score) ? "NULL" : $row->localteam_dl_data->score);
  $lo = "'" . $row->localteam_dl_data->overs . "'";
  $lw = (is_null($row->localteam_dl_data->wickets_out) ? "NULL" : $row->localteam_dl_data->wickets_out);
  $vs = (is_null($row->visitorteam_dl_data->score) ? "NULL" : $row->visitorteam_dl_data->score);
  $vo = "'" . $row->visitorteam_dl_data->overs ."'";
  $vw = (is_null($row->visitorteam_dl_data->wickets_out) ? "NULL" : $row->visitorteam_dl_data->wickets_out);
  $ro = "'" . $row->round . "'";
  $sa = "'" . $row->starting_at . "'";
  $ty = "'" . $row->type . "'";
  $li = "'" . $row->live . "'";
  $st = "'" . $row->status . "'";
  $lp = "'" . $row->last_period . "'";
  $no = "'" . $row->note . "'";
  $dn = "'" . $row->draw_noresult . "'";
  $el = "'" . $row->elected . "'";
  $so = "'" . $row->super_over . "'";
  $fo = "'" . $row->follow_on . "'";
  $fixid = (is_null($row->id) ? "NULL" : $row->id);
  $leai = (is_null($row->league_id) ? "NULL" : $row->league_id);
  $sei = (is_null($row->season_id) ? "NULL" : $row->season_id);
  $sti = (is_null($row->stage_id) ? "NULL" : $row->stage_id);
  $loi = (is_null($row->localteam_id) ? "NULL" : $row->localteam_id);
  $vii = (is_null($row->visitorteam_id) ? "NULL" : $row->visitorteam_id);
  $vei = (is_null($row->venue_id) ? "NULL" : $row->venue_id);
  $twi = (is_null($row->toss_won_team_id) ? "NULL" : $row->toss_won_team_id);
  $wti = (is_null($row->winner_team_id) ? "NULL" : $row->winner_team_id);
  $fui = (is_null($row->first_umpire_id) ? "NULL" : $row->first_umpire_id);
  $sui = (is_null($row->second_umpire_id) ? "NULL" : $row->second_umpire_id);
  $tui = (is_null($row->tv_umpire_id) ? "NULL" : $row->tv_umpire_id);
  $ri = (is_null($row->referee_id) ? "NULL" : $row->referee_id);
  $momi = (is_null($row->man_of_match_id) ? "NULL" : $row->man_of_match_id);
  $mosi = (is_null($row->man_of_series_id) ? "NULL" : $row->man_of_series_id);
  $top = "'" . $row->total_overs_played . "'";
  $rpo = (is_null($row->rpc_overs) ? "NULL" : $row->rpc_overs);
  $rpt = (is_null($row->rpc_target) ? "NULL" : $row->rpc_target);

  $query .= "INSERT INTO Fixtures (
    id,
    league_id,
    season_id,
    stage_id,
    round,
    localteam_id,
    visitorteam_id,
    starting_at,
    type,
    live,
    status,
    last_period,
    note,
    venue_id,
    toss_won_team_id,
    winner_team_id,
    draw_noresult,
    first_umpire_id,
    second_umpire_id,
    tv_umpire_id,
    referee_id,
    man_of_match_id,
    man_of_series_id,
    total_overs_played,
    elected,
    super_over,
    follow_on,
    localteam_dl_datascore,
    localteam_dl_dataovers,
    localteam_dl_datawickets_out,
    visitorteam_dl_datascore,
    visitorteam_dl_dataovers,
    visitorteam_dl_datawickets_out,
    rpc_overs,
    rpc_target) VALUES (
      $row->id,
      $leai,
      $sei,
      $sti,
      $ro,
      $loi,
      $vii,
      $sa,
      $ty,
      $li,
      $st,
      $lp,
      $no,
      $vei,
      $twi,
      $wti,
      $dn,
      $fui,
      $sui,
      $tui,
      $ri,
      $momi,
      $mosi,
      $top,
      $el,
      $so,
      $no,
      $ls,
      $lo,
      $lw,
      $vs,
      $vo,
      $vw,
      $rpo,
      $rpt)
      ON DUPLICATE KEY UPDATE
      id = VALUES(id),
      league_id = VALUES(league_id),
      season_id = VALUES(season_id),
      stage_id = VALUES(stage_id),
      round = VALUES(round),
      localteam_id = VALUES(localteam_id),
      visitorteam_id = VALUES(visitorteam_id),
      starting_at = VALUES(starting_at),
      type = VALUES(type),
      live = VALUES(live),
      status = VALUES(status),
      last_period = VALUES(last_period),
      note = VALUES(note),
      venue_id = VALUES(venue_id),
      toss_won_team_id = VALUES(toss_won_team_id),
      winner_team_id = VALUES(winner_team_id),
      draw_noresult = VALUES(draw_noresult),
      first_umpire_id = VALUES(first_umpire_id),
      second_umpire_id = VALUES(second_umpire_id),
      tv_umpire_id = VALUES(tv_umpire_id),
      referee_id = VALUES(referee_id),
      man_of_match_id = VALUES(man_of_match_id),
      man_of_series_id = VALUES(man_of_series_id),
      total_overs_played = VALUES(total_overs_played),
      elected = VALUES(elected),
      super_over = VALUES(super_over),
      follow_on = VALUES(follow_on),
      localteam_dl_datascore = VALUES(localteam_dl_datascore),
      localteam_dl_dataovers = VALUES(localteam_dl_dataovers),
      localteam_dl_datawickets_out = VALUES(localteam_dl_datawickets_out),
      visitorteam_dl_datascore = VALUES(visitorteam_dl_datascore),
      visitorteam_dl_dataovers = VALUES(visitorteam_dl_dataovers),
      visitorteam_dl_datawickets_out = VALUES(visitorteam_dl_datawickets_out),
      rpc_overs = VALUES(rpc_overs),
      rpc_target = VALUES(rpc_target),
      when_updated = '" . date('Y-m-d H:i:s') . "';";

  foreach ($row->runs as $key) {
    $runid = (is_null($key->id) ? "NULL" : $key->id);
    $runfid = (is_null($key->fixture_id) ? "NULL" : $key->fixture_id);
    $runtid = (is_null($key->team_id) ? "NULL" : $key->team_id);
    $runin = (is_null($key->inning) ? "NULL" : $key->inning);
    $runsc = (is_null($key->score) ? "NULL" : $key->score);
    $runwi = (is_null($key->wickets) ? "NULL" : $key->wickets);
    $runov = "'" . $key->overs . "'";
    $runpp1 = "'" . $key->pp1 . "'";
    $runpp2 = "'" . $key->pp2 . "'";
    $runpp3 = "'" . $key->pp3 . "'";
    $runua = "'" . $key->updated_at . "'";

    $query .= "INSERT INTO FixtureRuns (
          id,
          fixture_id,
          team_id,
          inning,
          score,
          wickets,
          overs,
          pp1,
          pp2,
          pp3,
          updated_at) VALUES (
            $runid,
            $runfid,
            $runtid,
            $runin,
            $runsc,
            $runwi,
            $runov,
            $runpp1,
            $runpp2,
            $runpp3,
            $runua)
            ON DUPLICATE KEY UPDATE
            id = VALUES(id),
            fixture_id = VALUES(fixture_id),
            team_id = VALUES(team_id),
            inning = VALUES(inning),
            score = VALUES(score),
            wickets = VALUES(wickets),
            overs = VALUES(overs),
            pp1 = VALUES(pp1),
            pp2 = VALUES(pp2),
            pp3 = VALUES(pp3),
            updated_at = VALUES(updated_at),
            when_updated = '" . date('Y-m-d H:i:s') . "';";
  }


  foreach ($row->batting as $key) {
    $batid = (is_null($key->id) ? "NULL" : $key->id);
    $batso = (is_null($key->sort) ? "NULL" : $key->sort);
    $batfid = (is_null($key->fixture_id) ? "NULL" : $key->fixture_id);
    $battid = (is_null($key->team_id) ? "NULL" : $key->team_id);
    $batac = "'" . $key->active . "'";
    $batsc = "'" . $key->scoreboard . "'";
    $batpid = (is_null($key->player_id) ? "NULL" : $key->player_id);
    $batba = (is_null($key->ball) ? "NULL" : $key->ball);
    $batsco = (is_null($key->score) ? "NULL" : $key->score);
    $batsid = (is_null($key->score_id) ? "NULL" : $key->score_id);
    $batfox = (is_null($key->four_x) ? "NULL" : $key->four_x);
    $batsix = (is_null($key->six_x) ? "NULL" : $key->six_x);
    $batcspid = (is_null($key->catch_stump_player_id) ? "NULL" : $key->catch_stump_player_id);
    $batboid = (is_null($key->batsmanout_id) ? "NULL" : $key->batsmanout_id);
    $batbpid = (is_null($key->bowling_player_id) ? "NULL" : $key->bowling_player_id);
    $batfows = (is_null($key->fow_score) ? "NULL" : $key->fow_score);
    $batfowb = (is_null($key->fow_balls) ? "NULL" : $key->fow_balls);
    $batra = (is_null($key->rate) ? "NULL" : $key->rate);
    $batua = "'" . $key->updated_at . "'";


    $query .= "INSERT INTO FixtureBatting (
          id,
          sort,
          fixture_id,
          team_id,
          active,
          scoreboard,
          player_id,
          ball,
          score_id,
          score,
          four_x,
          six_x,
          catch_stump_player_id,
          batsmanout_id,
          bowling_player_id,
          fow_score,
          fow_balls,
          rate,
          updated_at) VALUES (
            $batid,
            $batso,
            $batfid,
            $battid,
            $batac,
            $batsc,
            $batpid,
            $batba,
            $batsid,
            $batsco,
            $batfox,
            $batsix,
            $batcspid,
            $batboid,
            $batbpid,
            $batfows,
            $batfowb,
            $batra,
            $batua)
            ON DUPLICATE KEY UPDATE
            id = VALUES(id),
            sort = VALUES(sort),
            fixture_id = VALUES(fixture_id),
            team_id = VALUES(team_id),
            active = VALUES(active),
            scoreboard = VALUES(scoreboard),
            player_id = VALUES(player_id),
            ball = VALUES(ball),
            score_id = VALUES(score_id),
            score = VALUES(score),
            four_x = VALUES(four_x),
            six_x = VALUES(six_x),
            catch_stump_player_id = VALUES(catch_stump_player_id),
            batsmanout_id = VALUES(batsmanout_id),
            bowling_player_id = VALUES(bowling_player_id),
            fow_score = VALUES(fow_score),
            fow_balls = VALUES(fow_balls),
            rate = VALUES(rate),
            updated_at = VALUES(updated_at),
            when_updated = '" . date('Y-m-d H:i:s') . "';";
  }


  foreach ($row->bowling as $key) {
    $bowid = (is_null($key->id) ? "NULL" : $key->id);
    $bowso = (is_null($key->sort) ? "NULL" : $key->sort);
    $bowfid = (is_null($key->fixture_id) ? "NULL" : $key->fixture_id);
    $bowtid = (is_null($key->team_id) ? "NULL" : $key->team_id);
    $bowac = "'" . $key->active . "'";
    $bowsc = "'" . $key->scoreboard . "'";
    $bowpid = (is_null($key->player_id) ? "NULL" : $key->player_id);
    $bowov = "'" . $key->overs ."'";
    $bowme = (is_null($key->medians) ? "NULL" : $key->medians);
    $bowru = (is_null($key->runs) ? "NULL" : $key->runs);
    $bowwic = (is_null($key->wickets) ? "NULL" : $key->wickets);
    $bowwid = (is_null($key->wide) ? "NULL" : $key->wide);
    $bownb = (is_null($key->noball) ? "NULL" : $key->noball);
    $bowrat = (is_null($key->rate) ? "NULL" : $key->rate);
    $bowua = "'" . $key->updated_at . "'";


    $query .= "INSERT INTO FixtureBowling (
            id,
            sort,
            fixture_id,
            team_id,
            active,
            scoreboard,
            player_id,
            overs,
            medians,
            runs,
            wickets,
            wide,
            noball,
            rate,
            updated_at) VALUES (
              $bowid,
              $bowso,
              $bowfid,
              $bowtid,
              $bowac,
              $bowsc,
              $bowpid,
              $bowov,
              $bowme,
              $bowru,
              $bowwic,
              $bowwid,
              $bownb,
              $bowrat,
              $batua)
              ON DUPLICATE KEY UPDATE
              id = VALUES(id),
              sort = VALUES(sort),
              fixture_id = VALUES(fixture_id),
              team_id = VALUES(team_id),
              active = VALUES(active),
              scoreboard = VALUES(scoreboard),
              player_id = VALUES(player_id),
              overs = VALUES(overs),
              medians = VALUES(medians),
              runs = VALUES(runs),
              wickets = VALUES(wickets),
              wide = VALUES(wide),
              noball = VALUES(noball),
              rate = VALUES(rate),
              updated_at = VALUES(updated_at),
              when_updated = '" . date('Y-m-d H:i:s') . "';";
  }


  foreach ($row->scoreboards as $key) {
    $sbid = (is_null($key->id) ? "NULL" : $key->id);
    $sbfid = (is_null($key->fixture_id) ? "NULL" : $key->fixture_id);
    $sbtid = (is_null($key->team_id) ? "NULL" : $key->team_id);
    $sbty = "'" . $key->type . "'";
    $sbsc = "'" . $key->scoreboard . "'";
    $sbwid = (is_null($key->wide) ? "NULL" : $key->wide);
    $sbnbr = (is_null($key->noball_runs) ? "NULL" : $key->noball_runs);
    $sbnbb = (is_null($key->noball_balls) ? "NULL" : $key->noball_balls);
    $sbby = (is_null($key->bye) ? "NULL" : $key->bye);
    $sblby = (is_null($key->leg_bye) ? "NULL" : $key->leg_bye);
    $sbpen = (is_null($key->penalty) ? "NULL" : $key->penalty);
    $sbtot = (is_null($key->total) ? "NULL" : $key->total);
    $sbov = "'" .  $key->overs ."'";
    $sbwic = (is_null($key->wickets) ? "NULL" : $key->wickets);
    $sbua = "'" . $key->updated_at . "'";


    $query .= "INSERT INTO FixtureScorecard (
              id,
              fixture_id,
              team_id,
              type,
              scoreboard,
              wide,
              noball_runs,
              noball_balls,
              bye,
              leg_bye,
              penalty,
              total,
              overs,
              wickets,
              updated_at) VALUES (
                $sbid,
                $sbfid,
                $sbtid,
                $sbty,
                $sbsc,
                $sbwid,
                $sbnbr,
                $sbnbb,
                $sbby,
                $sblby,
                $sbpen,
                $sbtot,
                $sbov,
                $sbwic,
                $sbua)
                ON DUPLICATE KEY UPDATE
                id = VALUES(id),
                fixture_id = VALUES(fixture_id),
                team_id = VALUES(team_id),
                type = VALUES(type),
                scoreboard = VALUES(scoreboard),
                wide = VALUES(wide),
                noball_runs = VALUES(noball_runs),
                noball_balls = VALUES(noball_balls),
                bye = VALUES(bye),
                leg_bye = VALUES(leg_bye),
                penalty = VALUES(penalty),
                total = VALUES(total),
                overs = VALUES(overs),
                wickets = VALUES(wickets),
                updated_at = VALUES(updated_at),
                when_updated = '" . date('Y-m-d H:i:s') . "';";
  }

  foreach ($row->lineup as $key) {
    $luid = (is_null($key->id) ? "NULL" : $key->id);
    $lucid = (is_null($key->country_id) ? "NULL" : $key->country_id);
    $lufin = "'" . $key->firstname . "'";
    $luln = "'" . $key->lastname . "'";
    $lufun = "'" . $key->fullname . "'";
    $luip = "'" . $key->image_path . "'";
    $ludob = "'" . $key->dateofbirth . "'";
    $lugen = "'" . $key->gender . "'";
    $lubas = "'" . $key->battingstyle . "'";
    $lubos = "'" . $key->bowlingstyle . "'";
    $luposre = "'" . $key->position->resource . "'";
    $luposid = (is_null($key->position->id) ? "NULL" : $key->position->id);
    $luposna =  "'" . $key->position->name . "'";
    $luup = "'" . $key->updated_at . "'";
    $lutid = (is_null($key->lineup->team_id) ? "NULL" : $key->lineup->team_id);
    $lucap = "'" . $key->lineup->captain . "'";
    $luwik = "'" . $key->lineup->wicketkeeper . "'";
    $lusub = "'" . $key->lineup->substitution . "'";
    $luwu = "'" . date('Y-m-d H:i:s') . "'";

    $query .= "INSERT INTO FixtureLineup (
      id,
      fixture_id,
      country_id,
      firstname,
      lastname,
      fullname,
      image_path,
      dateofbirth,
      gender,
      battingstyle,
      bowlingstyle,
      positionresource,
      positionid,
      positionname,
      updated_at,
      lineupteam_id,
      lineupcaptain,
      lineupwicketkeeper,
      lineupsubstitution,
      when_updated) VALUES (
        $luid,
        $fixid,
        $lucid,
        $lufin,
        $luln,
        $lufun,
        $luip,
        $ludob,
        $lugen,
        $lubas,
        $lubos,
        $luposre,
        $luposid,
        $luposna,
        $luup,
        $lutid,
        $lucap,
        $luwik,
        $lusub,
        $luwu)
        ON DUPLICATE KEY UPDATE
        id = VALUES(id),
        fixture_id = VALUES(fixture_id),
        country_id = VALUES(country_id),
        firstname = VALUES(firstname),
        lastname = VALUES(lastname),
        fullname = VALUES(fullname),
        image_path = VALUES(image_path),
        dateofbirth = VALUES(dateofbirth),
        gender = VALUES(gender),
        battingstyle = VALUES(battingstyle),
        bowlingstyle = VALUES(bowlingstyle),
        positionresource = VALUES(positionresource),
        positionid = VALUES(positionid),
        positionname = VALUES(positionname),
        updated_at = VALUES(updated_at),
        lineupteam_id = VALUES(lineupteam_id),
        lineupcaptain = VALUES(lineupcaptain),
        lineupwicketkeeper = VALUES(lineupwicketkeeper),
        lineupsubstitution = VALUES(lineupsubstitution),
        when_updated = '" . date('Y-m-d H:i:s') . "';";
  }
}

//echo $query;

if ($connect->multi_query($query) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $query . "<br>" . $connect->error;
}
