Set WshShell = WScript.CreateObject("WScript.Shell")
sCmd = chr(34) & "path\dbCommand.bat" & chr(34)
dtmStartTime = Timer
Return = WshShell.Run(sCmd, 1, true)
Wscript.Echo "The task completed in " & Round(Timer - dtmStartTime, 2) & " seconds."