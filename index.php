<?php
$mapon = 1;
include('header.php');
?>

<div class="page-index">

<section id="geographical"></section>

<section id="listing">
  <nav><a href="javascript:void(0);" id="filtersSwitch" onclick="filtersDown()">filters</a></nav>
  <header>
    <h2 id="listing_title"><?php echo $labels[84]; ?></h2>
  </header>

  <article id="list"></article>
</section>

<section id="infoBox">
  <a href="acikradyo.php">Bağımsızlar her cuma 19.00'da <br>Apaçık Radyo'da</a>
</section>

<section id="listing_filters">
  <a class="accordion" onclick="panelAccordion(this)">Alphabetical</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties lett" name="0a"><span>A</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0b"><span>B</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0c"><span>C</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0d"><span>D</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0e"><span>E</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0f"><span>F</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0g"><span>G</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0h"><span>H</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0ı"><span>I</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0j"><span>J</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0k"><span>K</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0l"><span>L</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0m"><span>M</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0n"><span>N</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0o"><span>O</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0p"><span>P</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0q"><span>Q</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0r"><span>R</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0s"><span>S</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0t"><span>T</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0u"><span>U</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0v"><span>V</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0w"><span>W</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0x"><span>X</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0y"><span>Y</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0z"><span>Z</span></label>
    <label><input type="checkbox" class="filterProperties lett" name="0*"><span>*</span></label>
  </div>
  <a class="accordion" onclick="panelAccordion(this)">type</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties ty" name="t1"><span>Online</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ty" name="t0"><span>Distributed</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ty" name="t2"><span>Nomad</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ty" name="t3"><span>Settled</span><i class="hid"></i></label>
  </div>
  <a class="accordion" onclick="panelAccordion(this)">definition</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties de" name="d0"><span>Network</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d1"><span>Agent</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d2"><span>Research Collective</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d3"><span>Workshop</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d4"><span>Printed Publication</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d5"><span>Online Publication</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d6"><span>Dance/Circus Company</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d7"><span>Educational Institution</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d8"><span>GLAM (Gallery, Library, Archives, Museum)</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d9"><span>Hybrid Publication</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d10"><span>Cultural Centre</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d11"><span>Co-working Space</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d12"><span>Performance and Events Space</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d13"><span>Project Space</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d14"><span></span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d15"><span>Artistic Production Collective</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d16"><span>Artist-run Space</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d17"><span>Advocacy Initiative</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d18"><span>Civil Society Organization</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d19"><span>Theatre Collective</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d20"><span>Production Collective</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d21"><span>Productor</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties de" name="d22"><span>Publishing House</span><i class="hid"></i></label>
  </div>--<
  <a class="accordion" onclick="panelAccordion(this)">fields</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties fi" name="f0"><span>Archives and Preservation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f1"><span>Body Practices</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f2"><span>Science and Technology</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f3"><span>Environment and Agriculture</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f4"><span>Other</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f5"><span>Literature and Poetry</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f6"><span>Feminist Studies</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f7"><span>Visual Culture</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f8"><span>Visual Arts</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f9"><span>Urban Studies</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f10"><span>Queer Studies</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f11"><span>Cultural Heritage</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f12"><span>Cultural Management and Organization</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f13"><span>Media Studies</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f14"><span>Architecture</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f15"><span>Music and Sonic Arts</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f16"><span>Performance Arts</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f17"><span>Political and Social History</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f18"><span>Design</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f19"><span>Textile and Fashion</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f20"><span>Data and Information</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fi" name="f21"><span>Publishing</span><i class="hid"></i></label>
  </div>
  <a class="accordion" onclick="panelAccordion(this)">activities</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties ac" name="c0"><span>Networking</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c1"><span>Research &amp; Field Work</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c2"><span>Archiving &amp; Preservation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c3"><span>Other</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c4"><span>Training &amp; Education</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c5"><span>Festival</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c6"><span>Forum</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c7"><span>Screenings</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c8"><span>Hackathon</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c9"><span>Mapping</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c10"><span>Public Programs</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c11"><span>Capacity Building</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c12"><span>Public Intervention</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c13"><span>Conference &amp; Seminar</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c14"><span>Concert &amp; Sonic Performance</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c15"><span>Conservation &amp; Restoration</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c16"><span>Performance / Dance</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c17"><span>Artist Recidency Programme</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c18"><span>Advocacy</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c19"><span>Exhibition (Online and Physical)</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c20"><span>Theather play</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c21"><span>Production (Art, Food, Textile, etc.)</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c22"><span>Data Gathering &amp; Visualization</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ac" name="c23"><span>Walks &amp; Tours</span><i class="hid"></i></label>

  </div>
  <a class="accordion" onclick="panelAccordion(this)">legal status</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties ls" name="l0"><span>Association</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ls" name="l1"><span>Collective / Initiative</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ls" name="l2"><span>Cooperation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ls" name="l3"><span>Company</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties ls" name="l4"><span>Foundation</span><i class="hid"></i></label>
  </div>

  <a class="accordion" onclick="panelAccordion(this)">financial</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties fc" name="i0"><span>Renting</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i1"><span>Sales of Income Generating Production</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i2"><span>Product Or Service Sales</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i3"><span>Ticket Sale</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i4"><span>Personal Resources</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i5"><span>Sponsors</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i6"><span>Membership Fee</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i7"><span>Supporters</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i8"><span>Donations</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties fc" name="i9"><span>Funds</span><i class="hid"></i></label>

  </div>

  <a class="accordion" onclick="panelAccordion(this)">audience</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties au" name="a0"><span>General</span><i class="hid">Genel</i></label>
    <label><input type="checkbox" class="filterProperties au" name="a1"><span>Children</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a2"><span>Youth</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a3"><span>Elderly People</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a4"><span>Gender Groups</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a5"><span>Profession Groups</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a6"><span>Disabled people</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a7"><span>Disadvantaged groups</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a8"><span>Immigrants / Refugees / Asylum Seekers</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a9"><span>Stakeholders</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a10"><span>Local Governments</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a11"><span>Public Administration</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a12"><span>Media</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a13"><span>Non-Human</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties au" name="a14"><span>Other</span><i class="hid"></i></label>

  </div>
  <a class="accordion" onclick="panelAccordion(this)">services</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties rs" name="s0"><span>Public Relations &amp; Communication</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s1"><span>Video Editing</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s2"><span>Editorial Services</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s3"><span>Curatorial Services</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s4"><span>Coordination</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s5"><span>Facilitation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s6"><span>Translation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s7"><span>Exhibition Production</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s8"><span>Web Design &amp; Implementation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s9"><span>Photo Documentation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s10"><span>Video Documentation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s11"><span>Audio Documentation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s12"><span>Graphic Design</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s13"><span>Mentoring / Consulting</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s14"><span>Transportation</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s15"><span>Education</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s16"><span>Coding</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rs" name="s17"><span>Other</span><i class="hid"></i></label>
  </div>
  <a class="accordion" onclick="panelAccordion(this)">equipments</a>
  <div class="panel" style="max-height:0">
    <label><input type="checkbox" class="filterProperties rq" name="q0"><span>Photography Equipment</span><i class="hid">Fotoğraf Ekipmanları</i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q1"><span>Video Recording Equipment</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q2"><span>Audio Recording Equipment</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q3"><span>VR Equipment</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q4"><span>Sound System</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q5"><span>Light System</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q6"><span>Projector</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q7"><span>3D Printer</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q8"><span>Slide Projector</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q9"><span>Digital Printing Devices</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q10"><span>Render Computer</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q11"><span>Overhead Projector</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q12"><span>Monitor</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q13"><span>Swing Machine</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q14"><span>Agricultural Vehicles</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q15"><span>Vehicle</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q16"><span>Hardware's</span><i class="hid"></i></label>
    <label><input type="checkbox" class="filterProperties rq" name="q17"><span>Other</span><i class="hid"></i></label>
  </div>
</section>

<section id="organizationCard"></section>
<script type="text/javascript" src="js\indMapFoot.js"></script>

<?php
include 'footer.php';
?>
