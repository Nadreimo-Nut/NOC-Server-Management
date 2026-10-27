<?php

return [
    'nodes' => [
        'pve-01' => [
            'id' => 'pve-01',
            'name' => 'Alpha Master (pve-01)',
            'pool_name' => 'Alpha Pool Rack 01 (pve-01)',
            'location' => 'อาคาร Q ชั้น 1 (NOC Data Center Rack 01)',
            'ip' => '10.20.0.11',
            'cpu' => 'AMD EPYC 7742 (24 Cores)',
            'cpu_percent' => 18.5,
            'ram_usage' => '48.2 GB / 128 GB',
            'ram_percent' => 37.6,
            'vms' => 18,
            'max_vms' => 25,
            'uptime' => '45d 12h',
            'status' => 'ONLINE',
            'kernel' => 'Linux 6.8.4-2-pve'
        ],
        'pve-02' => [
            'id' => 'pve-02',
            'name' => 'Beta Worker (pve-02)',
            'pool_name' => 'Beta Pool Rack 02 (pve-02)',
            'location' => 'อาคาร Q ชั้น 1 (NOC Data Center Rack 02)',
            'ip' => '10.20.0.12',
            'cpu' => 'Intel Xeon Platinum (16 Cores)',
            'cpu_percent' => 12.1,
            'ram_usage' => '32.0 GB / 128 GB',
            'ram_percent' => 25.0,
            'vms' => 15,
            'max_vms' => 25,
            'uptime' => '45d 12h',
            'status' => 'ONLINE',
            'kernel' => 'Linux 6.8.4-2-pve'
        ],
        'pve-03' => [
            'id' => 'pve-03',
            'name' => 'Gamma AI Cluster (pve-03)',
            'pool_name' => 'Gamma Pool AI Lab (pve-03)',
            'location' => 'อาคาร Q ชั้น 1 (NOC Data Center Rack 03 AI Lab)',
            'ip' => '10.20.0.13',
            'cpu' => 'AMD EPYC + A100 GPU Cluster',
            'cpu_percent' => 78.4,
            'ram_usage' => '198.5 GB / 256 GB',
            'ram_percent' => 77.5,
            'vms' => 25,
            'max_vms' => 25,
            'uptime' => '19d 04h',
            'status' => 'FULL',
            'kernel' => 'Linux 6.8.4-2-pve'
        ],
    ],

    'os_templates' => [
        [
            'name' => 'Ubuntu 22.04 LTS',
            'desc' => 'General purpose, Docker, Python 3.10',
            'distro' => 'ubuntu',
            'icon' => 'fa-brands fa-ubuntu text-orange-400',
            'specs' => '2 vCPU / 2GB RAM / 100GB ZFS'
        ],
        [
            'name' => 'Debian 12 Bookworm',
            'desc' => 'Minimal & high stability production server',
            'distro' => 'debian',
            'icon' => 'devicon-debian-plain text-rose-500',
            'specs' => '2 vCPU / 2GB RAM / 100GB ZFS'
        ],
        [
            'name' => 'Rocky Linux 9',
            'desc' => 'RHEL Enterprise Standard for SysAdmin',
            'distro' => 'rocky',
            'icon' => 'fa-brands fa-redhat text-emerald-400',
            'specs' => '2 vCPU / 2GB RAM / 100GB ZFS'
        ],
        [
            'name' => 'Windows Server 2022',
            'desc' => '.NET, Active Directory, IIS Web Server',
            'distro' => 'windows',
            'icon' => 'fa-brands fa-windows text-blue-400',
            'specs' => '2 vCPU / 4GB RAM / 120GB ZFS'
        ],
    ],

    'telemetry' => [
        'cluster_cpu' => '24.2%',
        'cluster_ram' => '42.8%',
        'cluster_storage' => '18.4%',
        'cluster_vms' => 58,
    ]
];
