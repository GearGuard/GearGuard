@echo off

echo Starting Ratchet WebSocket server...
start "Ratchet Server" cmd /k php utilities/NotificationServer.php
