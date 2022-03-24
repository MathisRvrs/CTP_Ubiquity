<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class MyAuthFiles
  */
class MyAuthFiles extends AuthFiles{
	public function getViewIndex(): string{
		return "MyAuth/index.html";
	}

	public function getViewInfo(): string{
		return "MyAuth/info.html";
	}

	public function getViewNoAccess(): string{
		return "MyAuth/noAccess.html";
	}

	public function getViewDisconnected(): string{
		return "MyAuth/disconnected.html";
	}

	public function getViewMessage(): string{
		return "MyAuth/message.html";
	}

	public function getViewCreate(): string{
		return "MyAuth/create.html";
	}

	public function getViewStepTwo(): string{
		return "MyAuth/stepTwo.html";
	}

	public function getViewBaseTemplate(): string{
		return "MyAuth/baseTemplate.html";
	}

	public function getViewBadTwoFACode(): string{
		return "MyAuth/badTwoFACode.html";
	}

	public function getViewInitRecovery(): string{
		return "MyAuth/initRecovery.html";
	}

	public function getViewRecovery(): string{
		return "MyAuth/recovery.html";
	}


}
