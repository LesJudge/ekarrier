<?php
require 'library/uniweb/model/AjaxModel.php';
// Ar Helper.
require 'library/uniweb/ar/ArHelper.php'; // AR helper osztály.
// Exceptions
require 'library/uniweb/exceptions/ArBehaviorException.php'; // AR Behavior exception.
// AR Behavior
require 'library/uniweb/ar/ArBehavior.php'; // Abstract AR Behavior osztály.
require 'library/uniweb/ar/behavior/ArAuthorBehavior.php'; // Szerző behavior.
require 'library/uniweb/ar/behavior/ArLanguageBehavior.php'; // Nyelv behavior.
require 'library/uniweb/ar/behavior/ArTimestampBehavior.php'; // Időbélyeg behavior.
require 'library/uniweb/ar/behavior/ArNomBehavior.php'; // Módosítás száma behavior.
// Interface
require 'library/uniweb/ar/ISheepItAble.php'; // AR SheepIt interface.
require 'modul/ugyfel/library/IClientSave.php'; // Ügyfél mentés interface.
// Abstract
require 'library/uniweb/ar/ArBase.php'; // Abstract AR Model.
require 'library/uniweb/ar/ArEditable.php'; // Editable AR Model.
require 'library/uniweb/ar/SheepItNmArModel.php'; // SheepIt n:m kapcsolatot megvalósító AR Model.
require 'library/uniweb/ar/SheepItNmArMiscModel.php'; // SheepIt n:m kapcsolatot megvalósító AR Model egyéb mezővel.
require 'library/uniweb/ar/SaTSheepItNmArModel.php'; // Szolgáltatás és képzés n:m kapcsolatot megvalósító AR model.
// Ügyfél kezelő függőségek.
require 'modul/beallitas/model/ar/CameTo.php'; // Hova érkezett AR Model.
require 'modul/beallitas/model/ar/ContactType.php'; // Esetnapló típus AR Model.
require 'modul/beallitas/model/ar/Education.php'; // Végzettség AR Model.
require 'modul/beallitas/model/ar/WorkSchedule.php'; // Munkarend AR Model.
require 'modul/beallitas/model/ar/ProgramInformation.php'; // Program információ AR Model.
require 'modul/kepzes/model/ar/Training.php'; // Képzés AR Model.
require 'modul/munkakor/model/ar/Job.php'; // Munkakör AR Model.
require 'modul/munkakor/model/ar/JobCategory.php'; // Munkakör kategória AR Model.
require 'modul/munkakor/model/JobCreator.php'; // Munkakör létrehozó model.
require 'modul/nyelvtudas/model/ar/KnowledgeLanguage.php'; // Nyelvtudás nyelv AR Model.
require 'modul/nyelvtudas/model/ar/KnowledgeLevel.php'; // Nyelvtudás szint AR Model.
require 'modul/szolgaltatas/model/ar/Service.php'; // Szolgáltatás AR Model.
require 'modul/projekt/model/ar/Project.php'; // Projekt AR Model.
require 'modul/user_cim/model/ar/Country.php'; // Ország AR Model.
require 'modul/user_cim/model/ar/County.php'; // Megye AR Model.
require 'modul/user_cim/model/ar/City.php'; // Város AR Model.
require 'modul/user_cim/model/ar/ZipCode.php'; // Irányítószám AR Model.
// Ügyfél kezelő modelek.
require 'modul/ugyfel/model/ar/User.php'; // Alap User AR Model.
require 'modul/ugyfel/model/ar/Client.php'; // Ügyfél AR Model.
require 'modul/ugyfel/model/ar/ClientData.php'; // Ügyfél adatai AR Model.
require 'modul/ugyfel/model/ar/UserEducation.php'; // Tanulmányok AR Model.
require 'modul/ugyfel/model/ar/UserKnowledge.php'; // Nyelvtudás AR Model.
require 'modul/ugyfel/model/ar/UcKnowledge.php'; // Számítógépes ismeretek AR Model.
require 'modul/ugyfel/model/ar/LaborMarket.php'; // Munkaerő piaci helyzet AR Model.
require 'modul/ugyfel/model/ar/ProjectInformation.php'; // Program információ AR Model.
require 'modul/ugyfel/model/ar/TrainingInterested.php'; // Érdekelt képzések AR Model.
require 'modul/ugyfel/model/ar/ServiceInterested.php'; // Érdekelt szolgáltatások AR Model.
require 'modul/ugyfel/model/ar/ClientContact.php'; // Ügyfélhez tartozó kapcsolatfelvételek.
require 'modul/ugyfel/model/ar/ClientProgramInformation.php'; // Ügyfélhez tartozó program információ adatok.
require 'modul/ugyfel/model/ar/ClientWorkSchedules.php'; // Ügyfélhez tartozó munkarend adatok.
require 'modul/ugyfel/model/ar/ClientMediation.php'; // Ügyfél közvetítés AR Model.
require 'modul/ugyfel/model/ar/ClientDocument.php'; // Ügyfél dokumentum AR Model.
require 'modul/ugyfel/model/ar/ClientJob.php'; // Ügyfél munkakör AR Model.
require 'modul/ugyfel/model/ar/ClientProject.php'; // Ügyfél projekt AR Model.
require 'modul/ugyfel/model/ar/ClientState.php'; // Ügyfél állapot AR Model.
require 'modul/ugyfel/model/ar/ClientStatus.php'; // Ügyfél státusz AR Model.
require 'modul/ugyfel/model/ar/ClientComment.php'; // Ügyfél megjegyzés AR Model.
require 'modul/ugyfel/model/ar/ClientAddress.php'; // Ügyfél cím AR Model.
require 'modul/ugyfel/model/ar/Address/Residence.php';
require 'modul/ugyfel/model/ar/Address/DwellingPlace.php';
require 'modul/ugyfel/model/ar/Address/TemporaryResidence.php';
require 'modul/ugyfel/model/ar/Comment/CommentActivity.php';
require 'modul/ugyfel/model/ar/Comment/CommentClientInformation.php';
require 'modul/ugyfel/model/ar/Comment/CommentContact.php';
require 'modul/ugyfel/model/ar/Comment/CommentDocument.php';
require 'modul/ugyfel/model/ar/Comment/CommentEducation.php';
require 'modul/ugyfel/model/ar/Comment/CommentJob.php';
require 'modul/ugyfel/model/ar/Comment/CommentLaborMarket.php';
require 'modul/ugyfel/model/ar/Comment/CommentLogin.php';
require 'modul/ugyfel/model/ar/Comment/CommentPersonalData.php';
require 'modul/ugyfel/model/ar/Comment/CommentProject.php';
require 'modul/ugyfel/model/ar/Comment/CommentProjectInformation.php';
require 'modul/ugyfel/model/ar/ClientDataStatus.php';
require 'modul/ugyfel/model/ar/ClientBirthData.php';