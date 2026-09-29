<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Per-instance cursor over $fixtures. Deliberately not `static`: a
     * process-global counter makes factory output depend on test execution
     * order, which is exactly the flakiness this is replacing.
     */
    private int $cursor = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $posts = [
            [
                'title' => 'Understanding Penetration Testing: A Complete Guide for African Enterprises',
                'slug' => 'understanding-penetration-testing-complete-guide-african-enterprises',
                'excerpt' => 'Penetration testing is no longer optional for organizations serious about cybersecurity. Learn why African enterprises must adopt proactive security testing to protect their digital assets.',
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&h=400&fit=crop',
                'content' => 'Penetration testing, often called pen testing or ethical hacking, is a simulated cyber attack against your computer system to check for exploitable vulnerabilities. In the context of web application security, penetration testing is commonly used to augment a web application firewall (WAF).\n\n## Why Penetration Testing Matters for African Enterprises\n\nAs African businesses accelerate their digital transformation, the attack surface expands dramatically. According to recent reports, cyber attacks on African organizations have increased by over 300% in the past three years.\n\n### Key Benefits\n\n1. **Identify Vulnerabilities Before Attackers Do** - Regular pen testing reveals weaknesses in your infrastructure, applications, and processes.\n2. **Regulatory Compliance** - Many African nations are implementing data protection laws (like Nigeria\'s NDPR, Kenya\'s Data Protection Act, South Africa\'s POPIA) that require security assessments.\n3. **Business Continuity** - Understanding your security posture helps prevent costly breaches and downtime.\n\n## Types of Penetration Testing\n\n- **Network Penetration Testing** - Assesses network infrastructure for vulnerabilities\n- **Web Application Testing** - Focuses on web apps, APIs, and mobile backends\n- **Social Engineering** - Tests human factors through phishing and other tactics\n- **Physical Security Testing** - Evaluates physical access controls\n\n## The EINEVA Labs Approach\n\nAt EINEVA Labs, we follow a rigorous methodology aligned with industry standards like OWASP, NIST, and PTES. Our assessments go beyond automated scanning to include manual exploitation and business logic testing.\n\n> "Security is not a product, but a process." — Bruce Schneier\n\n## Getting Started\n\nOrganizations should conduct penetration tests at least annually, and after any significant infrastructure changes. Contact our team to discuss your specific requirements.',
            ],
            [
                'title' => 'Building a DevSecOps Pipeline: Integrating Security into CI/CD',
                'slug' => 'building-devsecops-pipeline-integrating-security-ci-cd',
                'excerpt' => 'DevSecOps shifts security left in the development lifecycle. Discover practical steps to embed security checks into your CI/CD pipeline without slowing down delivery.',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=400&fit=crop',
                'content' => 'Traditional security approaches often treat security as a gate at the end of development. DevSecOps changes this by integrating security practices throughout the software development lifecycle.\n\n## The DevSecOps Philosophy\n\nDevSecOps stands for Development, Security, and Operations. It\'s about making security everyone\'s responsibility, not just the security team\'s.\n\n### Core Principles\n\n1. **Shift Left** - Move security testing earlier in the development process\n2. **Automation** - Automate security checks in the pipeline\n3. **Continuous Feedback** - Provide developers immediate feedback on security issues\n4. **Shared Responsibility** - Security is everyone\'s job\n\n## Essential Pipeline Stages\n\n### 1. Static Application Security Testing (SAST)\nAnalyze source code for vulnerabilities before compilation:\n```yaml\n- name: SAST Scan\n  run: semgrep --config=auto .\n```\n\n### 2. Software Composition Analysis (SCA)\nCheck dependencies for known vulnerabilities:\n```yaml\n- name: Dependency Check\n  run: npm audit || snyk test\n```\n\n### 3. Dynamic Application Security Testing (DAST)\nTest running applications for runtime vulnerabilities:\n```yaml\n- name: DAST Scan\n  run: zap-baseline.py -t https://staging.example.com\n```\n\n### 4. Container Security\nScan container images for vulnerabilities:\n```yaml\n- name: Container Scan\n  run: trivy image myapp:latest\n```\n\n## Implementation Roadmap\n\n**Phase 1: Foundation** (Month 1-2)\n- Enable SAST on all repositories\n- Add dependency scanning\n- Create security policies\n\n**Phase 2: Integration** (Month 3-4)\n- Add DAST to staging deployments\n- Implement container scanning\n- Set up security dashboards\n\n**Phase 3: Maturity** (Month 5+)\n- Add threat modeling to design phase\n- Implement runtime protection\n- Continuous compliance monitoring\n\n## Common Challenges\n\n- **False Positives** - Tune rules and create baselines\n- **Developer Resistance** - Provide training and make tools developer-friendly\n- **Pipeline Speed** - Run scans in parallel, use incremental analysis\n\n## Measuring Success\n\nTrack these metrics:\n- Time to remediate critical vulnerabilities\n- Percentage of builds passing security gates\n- Number of vulnerabilities caught in pipeline vs production\n- Developer satisfaction with security tooling\n\nEINEVA Labs helps organizations design and implement DevSecOps pipelines tailored to their tech stack and compliance requirements.',
            ],
            [
                'title' => 'Threat Intelligence in Africa: Landscape, Challenges, and Opportunities',
                'slug' => 'threat-intelligence-africa-landscape-challenges-opportunities',
                'excerpt' => 'Africa\'s threat landscape is unique and rapidly evolving. Explore the key threat actors, emerging trends, and how organizations can build effective threat intelligence programs.',
                'image' => 'https://images.unsplash.com/photo-1563206767-5b18f218e8de?w=800&h=400&fit=crop',
                'content' => 'Threat intelligence is evidence-based knowledge about existing or emerging threats to assets. For African organizations, understanding the local threat landscape is critical for effective defense.\n\n## Africa\'s Unique Threat Landscape\n\n### Key Threat Actors\n\n1. **Nation-State Actors** - Increasingly targeting critical infrastructure and government systems\n2. **Cybercriminal Groups** - Financially motivated, often using ransomware and business email compromise\n3. **Hacktivists** - Politically motivated, targeting organizations for ideological reasons\n4. **Insider Threats** - Both malicious and accidental\n\n### Prevalent Attack Vectors\n\n- **Business Email Compromise (BEC)** - Africa loses billions annually to BEC scams\n- **Ransomware** - Growing exponentially, targeting SMEs and large enterprises alike\n- **Mobile Money Fraud** - Exploiting the continent\'s mobile financial services\n- **Supply Chain Attacks** - Targeting third-party vendors and service providers\n\n## Building a Threat Intelligence Program\n\n### 1. Define Intelligence Requirements\nStart with Priority Intelligence Requirements (PIRs):\n- What assets are we protecting?\n- Who are the likely adversaries?\n- What decisions need threat intelligence support?\n\n### 2. Collection Sources\n- **Open Source Intelligence (OSINT)** - Public reports, threat feeds, social media\n- **Commercial Feeds** - Premium threat intelligence platforms\n- **Information Sharing Communities** - Industry ISACs, government CERTs\n- **Internal Sources** - Logs, incident reports, honeypots\n\n### 3. Processing and Analysis\n- **Tactical Intelligence** - IOCs, malware signatures, attack patterns\n- **Operational Intelligence** - TTPs, campaign tracking, actor profiles\n- **Strategic Intelligence** - Trends, geopolitical analysis, risk assessments\n\n### 4. Dissemination and Action\n- Automated IOC sharing to security tools\n- Regular threat briefings for leadership\n- Integration with SOC workflows\n\n## Challenges in the African Context\n\n- **Limited Local Threat Intelligence** - Few Africa-specific commercial feeds\n- **Skills Gap** - Shortage of trained threat intelligence analysts\n- **Data Sovereignty** - Regulations on cross-border data sharing\n- **Resource Constraints** - Budget limitations for tools and personnel\n\n## Opportunities\n\n- **Regional Collaboration** - African Union cybersecurity initiatives\n- **Local Threat Intelligence Platforms** - Growing ecosystem of African cybersecurity startups\n- **Mobile-First Intelligence** - Leveraging Africa\'s mobile dominance for threat detection\n- **Capacity Building** - Training programs and certifications\n\n## EINEVA Labs Threat Intelligence Services\n\nWe provide:\n- Custom threat intelligence feeds for African contexts\n- Threat hunting and compromise assessments\n- Incident response and forensic analysis\n- Security awareness training tailored to local threats\n\nContact us to strengthen your threat intelligence capabilities.',
            ],
            [
                'title' => 'Secure Software Development Lifecycle (SSDLC): A Practical Framework',
                'slug' => 'secure-software-development-lifecycle-ssdlc-practical-framework',
                'excerpt' => 'Building security into software from the start is more effective and cheaper than fixing vulnerabilities later. Learn a practical SSDLC framework for your team.',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=400&fit=crop',
                'content' => 'The Secure Software Development Lifecycle (SSDLC) integrates security practices into every phase of software development. It\'s not a separate process—it\'s how you build software securely.\n\n## Why SSDLC Matters\n\n- **Cost Reduction** - Fixing a vulnerability in design costs 10x less than in production\n- **Risk Reduction** - Fewer vulnerabilities reach production\n- **Compliance** - Meets regulatory requirements for secure development\n- **Customer Trust** - Demonstrates commitment to security\n\n## The SSDLC Phases\n\n### 1. Requirements & Design\n**Security Activities:**\n- Threat modeling (STRIDE, PASTA, or attack trees)\n- Security requirements definition\n- Architecture risk analysis\n- Data classification and privacy impact assessment\n\n**Deliverables:**\n- Threat model document\n- Security requirements specification\n- Architecture decision records with security rationale\n\n### 2. Implementation\n**Security Activities:**\n- Secure coding standards (OWASP Top 10, CWE Top 25)\n- Code review with security focus\n- Static analysis (SAST) in IDE and CI\n- Dependency management and SCA\n- Secrets management\n\n**Deliverables:**\n- Secure coding checklist\n- SAST/SCA scan reports\n- Approved dependency list\n\n### 3. Verification\n**Security Activities:**\n- Dynamic analysis (DAST) in staging\n- Penetration testing\n- Security regression testing\n- Fuzzing for critical components\n- Container and infrastructure scanning\n\n**Deliverables:**\n- Penetration test report\n- DAST scan results\n- Security test coverage metrics\n\n### 4. Release\n**Security Activities:**\n- Release security checklist\n- Vulnerability triage and acceptance criteria\n- Deployment security validation\n- Rollback plan for security issues\n\n**Deliverables:**\n- Release security sign-off\n- Known vulnerabilities register\n- Deployment runbook\n\n### 5. Operations & Maintenance\n**Security Activities:**\n- Vulnerability management program\n- Security monitoring and alerting\n- Incident response procedures\n- Regular penetration testing\n- Patch management\n\n**Deliverables:**\n- Vulnerability SLA dashboard\n- Incident response playbooks\n- Patch deployment reports\n\n## Implementing SSDLC: A Maturity Model\n\n### Level 1: Ad Hoc\n- Occasional security testing\n- No formal process\n- Reactive vulnerability response\n\n### Level 2: Defined\n- Documented security requirements\n- SAST in CI pipeline\n- Annual penetration testing\n\n### Level 3: Managed\n- Threat modeling for major features\n- DAST in staging\n- Security champions program\n- Metrics and reporting\n\n### Level 4: Optimized\n- Continuous threat modeling\n- Runtime application self-protection (RASP)\n- Automated compliance checking\n- Predictive vulnerability management\n\n## Getting Started\n\n1. **Assess Current State** - Gap analysis against SSDLC framework\n2. **Start Small** - Pick one team, one application\n3. **Build Security Champions** - Train developers as security advocates\n4. **Automate Gradually** - Add one tool at a time\n5. **Measure and Improve** - Track metrics, iterate\n\nEINEVA Labs offers SSDLC assessments, training, and implementation support tailored to your development practices and technology stack.',
            ],
            [
                'title' => 'Ransomware Preparedness: A Playbook for African Organizations',
                'slug' => 'ransomware-preparedness-playbook-african-organizations',
                'excerpt' => 'Ransomware attacks are surging across Africa. This playbook provides actionable steps to prepare for, respond to, and recover from ransomware incidents.',
                'image' => 'https://images.unsplash.com/photo-1614064641938-3bbee5d9106c?w=800&h=400&fit=crop',
                'content' => 'Ransomware has become the most significant cyber threat facing African organizations. In 2023, ransomware attacks on African entities increased by over 200%, with average ransom demands exceeding $500,000.\n\n## Understanding the Ransomware Threat\n\n### Current Trends in Africa\n\n1. **Double Extortion** - Attackers encrypt data AND threaten to leak it\n2. **Ransomware-as-a-Service (RaaS)** - Lowering barrier to entry for attackers\n3. **Targeting Backups** - Modern ransomware specifically hunts for backup systems\n4. **Living Off the Land** - Using legitimate admin tools to evade detection\n\n### Common Initial Access Vectors\n\n- Phishing emails (still #1)\n- Exploited VPN/RDP vulnerabilities\n- Compromised third-party vendors\n- Unpatched internet-facing systems\n- Supply chain attacks\n\n## Preparation Phase\n\n### 1. Immutable Backups (Critical)\n- **3-2-1 Rule**: 3 copies, 2 media types, 1 offsite/offline\n- Test restoration quarterly\n- Protect backup management interfaces\n- Consider air-gapped or immutable storage\n\n### 2. Network Segmentation\n- Isolate critical systems\n- Restrict lateral movement\n- Implement zero-trust principles\n- Monitor inter-segment traffic\n\n### 3. Endpoint Detection and Response (EDR)\n- Deploy on all endpoints\n- Enable tamper protection\n- Configure automated response actions\n- Integrate with SIEM/SOAR\n\n### 4. Identity and Access Management\n- Enforce MFA everywhere (especially VPN, email, admin)\n- Implement privileged access management (PAM)\n- Regular access reviews\n- Service account inventory and rotation\n\n### 5. Incident Response Plan\n- Define roles and responsibilities\n- Create communication templates\n- Establish legal/regulatory notification procedures\n- Identify external incident response partners\n- Conduct tabletop exercises quarterly\n\n## Detection Phase\n\n### Key Indicators of Compromise\n- Unusual encryption activity\n- Mass file modifications\n- Suspicious process execution (vssadmin, wbadmin, bcdedit)\n- Network scanning activity\n- Unauthorized administrative tool usage\n\n### Monitoring Priorities\n1. Backup system access attempts\n2. Domain controller anomalies\n3. Privilege escalation events\n4. Data exfiltration indicators\n5. Known ransomware IOCs\n\n## Response Phase\n\n### Immediate Actions (First Hour)\n1. **Isolate** - Disconnect affected systems from network\n2. **Preserve** - Do not power off (memory forensics)\n3. **Notify** - Activate incident response team\n4. **Assess** - Determine scope and variant\n5. **Communicate** - Internal stakeholders, legal, PR\n\n### Investigation\n- Identify initial access vector\n- Determine lateral movement path\n- Assess data exfiltration\n- Check backup integrity\n- Identify ransomware variant\n\n### Recovery Decision Framework\n```\nIF clean backups exist AND restored quickly:\n    → Restore from backups\nELSE IF decryptor available:\n    → Use decryptor\nELSE IF business impact catastrophic:\n    → Consider negotiation (with law enforcement)\nELSE:\n    → Rebuild from scratch\n```\n\n## Recovery Phase\n\n### System Restoration\n1. Rebuild compromised systems from known-good images\n2. Reset all credentials (assume all compromised)\n3. Apply all security patches\n4. Implement additional controls\n5. Monitor closely for 30+ days\n\n### Post-Incident Activities\n- Root cause analysis\n- Lessons learned documentation\n- Update IR plan and controls\n- Regulatory notifications\n- Stakeholder communication\n\n## African Context Considerations\n\n- **Law Enforcement** - Engage national CERTs early (e.g., Nigeria\'s ngCERT, Kenya\'s KE-CIRT)\n- **Regulatory** - Data breach notification requirements vary by country\n- **Payment** - Cryptocurrency regulations affect ransom payment options\n- **Insurance** - Cyber insurance markets developing but limited\n\n## EINEVA Labs Ransomware Services\n\n- Ransomware readiness assessments\n- Tabletop exercises and simulations\n- Incident response retainer\n- Post-breach forensics and recovery\n- Security awareness training (anti-phishing focus)\n\nDon\'t wait for an attack. Prepare now.',
            ],
        ];

        /*
         * The original factory cycled a hardcoded array through a
         * `static $index` counter. That counter is process-global, so the
         * content a factory call returned depended on how many other tests
         * had run first - two tests asserting on the same post got different
         * rows, and running a single test in isolation produced a different
         * one again. The fixtures are kept, but indexed per instance.
         */
        $post = $posts[$this->cursor++ % count($posts)];

        return [
            'title' => $post['title'],
            /*
             * The fixture slugs are unique to the fixture, not to the run.
             * Once the five fixtures are exhausted the cursor wraps and the
             * second insert collides with posts.slug, so any test creating
             * more than five posts failed on a UNIQUE violation rather than on
             * what it meant to assert.
             */
            'slug' => $post['slug'].'-'.$this->faker->unique()->numberBetween(1, 999999),
            'excerpt' => $post['excerpt'],
            'image' => $post['image'],
            'content' => $post['content'],
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            /*
             * Published by default. The public blog only shows rows where
             * published_at is set and in the past, so an unpublished factory
             * made every storefront assertion a 404 for reasons that had
             * nothing to do with the test. Use ->draft() to test the gate.
             */
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * An unpublished draft: invisible to the public blog and 404 at
     * /blog/<slug>.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'published_at' => null,
        ]);
    }

    /**
     * Scheduled for the future: has a publish date, so it is still hidden
     * until that date passes.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'published_at' => now()->addWeek(),
        ]);
    }
}
