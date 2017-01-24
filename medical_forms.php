<html lang="en">
<head>
  <title>Medical Forms</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <?php
  session_start();
  if (!empty($_SESSION["username"])) {
    $departure_name = $_GET["departure_name"];
    $departure_time = $_GET["departure_time"];
    $departure_date = $_GET["departure_date"];

    include 'functions/connect.php';

    $get_medical_forms = mysqli_query($connect, "SELECT * FROM medical_log WHERE DepartureName = '$departure_name' AND DepartureTime = '$departure_time' AND DepartureDate = '$departure_date' AND Operator = '".$_SESSION["operator"]."'");
    $medical_forms_num_rows = mysqli_num_rows($get_medical_forms);

    if ($medical_forms_num_rows > 0) {
     $medical_forms[] = mysqli_fetch_assoc($get_medical_forms);
   } else {
    $medical_forms = "false";
  }
  ?>

  <div class="container-fluid">
    <h2>Medical Forms: <?php echo date("l jS F, Y", strtotime($departure_date)) ?></h2>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th>Booking Number</th>
          <th>Departure Name</th>
          <th>Departure Time</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Medical Conditions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($medical_forms != "false") {
          foreach ($medical_forms as $value) {
           $tr_class = "active";
           if ($value["AnkleInjuries"] == "Yes" OR $value["HeartConditions"] == "Yes" OR $value["Pregnancy"] == "Yes" OR $value["KneeInjuries"] == "Yes" OR $value["VisualImpairment"] == "Yes" OR $value["Epilepsy"] == "Yes" OR $value["JointReplacement"] == "Yes" OR $value["Diabetes"] == "Yes" OR $value["SevereAllergies"] == "Yes" OR $value["Dislocations"] == "Yes" OR $value["Asthma"] == "Yes" OR $value["PreviousSurgery"] == "Yes" OR $value["NeckBackInjuries"] == "Yes" OR $value["RespiratoryConditions"] == "Yes" OR $value["BloodPressureMedication"] == "Yes" OR $value["Medication"] != "None" OR $value["OtherMedicalConditions"] != "None") {
            $tr_class = "danger";
          }
          echo "
          <tr class='$tr_class'>
           <td>".$value["BookingReference"]."</td>
           <td>".$value["DepartureName"]."</td>
           <td>".$value["DepartureTime"]."</td>
           <td>".$value["FirstName"]."</td>
           <td>".$value["LastName"]."</td>
           <td>";
            $medical_issues = "false";
            if ($value["AnkleInjuries"] == "Yes") {echo "Ankle Injuries<br>"; $medical_issues = "true";}
            if ($value["HeartConditions"] == "Yes") {echo "Heart Conditions<br>"; $medical_issues = "true";}
            if ($value["Pregnancy"] == "Yes") {echo "Pregnancy<br>"; $medical_issues = "true";}
            if ($value["KneeInjuries"] == "Yes") {echo "Knee Injuries<br>"; $medical_issues = "true";}
            if ($value["VisualImpairment"] == "Yes") {echo "Visual Impairment<br>"; $medical_issues = "true";}
            if ($value["Epilepsy"] == "Yes") {echo "Epilepsy<br>"; $medical_issues = "true";}
            if ($value["JointReplacement"] == "Yes") {echo "Joint Replacement<br>"; $medical_issues = "true";}
            if ($value["Diabetes"] == "Yes") {echo "Diabetes<br>"; $medical_issues = "true";}
            if ($value["SevereAllergies"] == "Yes") {echo "Severe Allergies<br>"; $medical_issues = "true";}
            if ($value["Dislocations"] == "Yes") {echo "Dislocations<br>"; $medical_issues = "true";}
            if ($value["Asthma"] == "Yes") {echo "Asthma<br>"; $medical_issues = "true";}
            if ($value["PreviousSurgery"] == "Yes") {echo "Previous Surgery<br>"; $medical_issues = "true";}
            if ($value["NeckBackInjuries"] == "Yes") {echo "Neck or Back Injuries<br>"; $medical_issues = "true";}
            if ($value["RespiratoryConditions"] == "Yes") {echo "Respiratory Conditions<br>"; $medical_issues = "true";}
            if ($value["BloodPressureMedication"] == "Yes") {echo "Blood Pressure Medication<br>"; $medical_issues = "true";}
            if ($value["Medication"] == "Yes") {echo "Medication: ".$value["Medication"]."<br>"; $medical_issues = "true";}
            if ($value["OtherMedicalConditions"] == "Yes") {echo "Other Medical Conditions: ".$OtherMedicalConditions."<br>"; $medical_issues = "true";}
            if ($medical_issues == "false") {echo "None";}
            echo "</td>
          </tr>";
        }
      } else {
        echo "
        <tr>
          <td>No results.</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php
} else {
  header('Location: http://213.213.140.146/');
}
?>
</body>
</html>