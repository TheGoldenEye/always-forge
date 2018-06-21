# always-forge
**AlwaysForge** is PHP forging fail-over for **Lisk** cryptocurrency. It will monitor all your nodes in real-time and switch forging to best server available. It uses active (maybe a little too aggressive) approach and best practices.

## Version:
`2.0.0`
This version **works only with the Lisk Core 1.0.0 codebase**, starting with Version 1.0.0-beta.9 (currently running in Lisk Betanet)
For older Lisk versions 0.9.x (Mainnet & Testnet) please use the previous always-forge version 1.0 from 4miners https://github.com/4miners/always-forge

## Dependencies:
Script require **PHP** with **cURL** support and **Cron**. If you want to run it on hosting instead of VPS - one with **SLA 99.99%** is highly recommended.

## Installation:
**Remember to add your monitor's server IP to lisk whitelist (for API and forging)!**

```
git clone https://github.com/TheGoldenEye/always-forge
cd always-forge
cp config.json.example config.json
```
Edit `config.json` to your needs:
```
{
    "log_level": "info", // Log details level: debug, info, none
    "check_interval_sec": 1, // Checker will pause for that interval each loop
    "timeouts": {
        "request_sec": 3, // Timeout for cURL request, must be higher than connect_msec
        "connect_msec": 1000 // Timeout for cURL connection establishment
    },
    "delegate": {
        "address": "delegate_address", // Your delegate address
        "publicKey": "delegate_publicKey", // Your delegate public key
        "password": "delegate_password" // The password with which your delegate secret was encrypted
    },
    // List of servers, first server will have highest priority, last - lowest priority
    // Each server must have unique name! Set 'scheme' to http or https.
    "servers": [
        {
            "name": "node1",
            "scheme": "http",
            "ip": "127.0.0.1",
            "port": 5000
        },
        {
            "name": "node2",
            "scheme": "http",
            "ip": "a.b.c.d",
            "port": 5000
        }
    ]
}
```

Save config and test it:
```
php always_forge.php
```
If it works - add to your crontab `monitor_always_forge.sh` to run every minute, for example: `crontab -e`, then insert:
```
* * * * * bash /home/lisk/always-forge/monitor_always_forge.sh
```

## Authors
- Goldeneye
- Mariusz Serek (4miners)

**Many thanks to 4miners for his great work on always-forge !!!**
