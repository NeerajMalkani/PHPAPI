<?php
$connect = new mysqli("184.168.99.250", "neerajmalkani", "secure@MySQL", "cricketdb"); //Connect PHP to MySQL Database
date_default_timezone_set('asia/kolkata');
$date = new DateTime();
$date->modify('+4 day');
$date1 = new DateTime();
$date1->modify('-4 day');
$service_url = "https://cricket.sportmonks.com/api/v2.0/fixtures?filter[starts_between]=" . $date1->format('Y-m-d') . "," . $date->format('Y-m-d') . "&include=runs&sort=id&api_token=9zC8IKVOFPGJyGkyrGk9n1eEpSEeDIyjWqprJYO9vMZ5Yyo9HSgfmWc0y7U7";
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$fixturesList = curl_exec($curl);
curl_close($curl);
$fixturesList = json_decode($fixturesList);
$array = (array) $fixturesList->data;
$query = "";
foreach ($array as $row) {
  $ls = (is_null($row->localteam_dl_data->score) ? "NULL" : $row->localteam_dl_data->score);
  $lo = (is_null($row->localteam_dl_data->overs) ? "NULL" : $row->localteam_dl_data->overs);
  $lw = (is_null($row->localteam_dl_data->wickets_out) ? "NULL" : $row->localteam_dl_data->wickets_out);
  $vs = (is_null($row->visitorteam_dl_data->score) ? "NULL" : $row->visitorteam_dl_data->score);
  $vo = (is_null($row->visitorteam_dl_data->overs) ? "NULL" : $row->visitorteam_dl_data->overs);
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
  $top = (is_null($row->total_overs_played) ? "NULL" : $row->total_overs_played);
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
    $runov = (is_null($key->overs) ? "NULL" : $key->overs);
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
}

//echo $query;

if ($connect->multi_query($query) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $query . "<br>" . $connect->error;
}
