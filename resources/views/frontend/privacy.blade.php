@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Privacy Policy</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <p>Urge Care Health Solutions LLP, hereinafter referred to as Urgecare. We are dedicated to ensuring
                the privacy and security of your personal information. This Privacy Policy explains how we collect, use,
                and protect the information you provide to us through our website and services. By accessing our website
                and utilizing our services, you agree to the terms of this Privacy Policy.</p>

            <h2 class="sec-title mb-3">1. Information We Collect</h2>
            <p>We may collect personal information from you when you voluntarily provide it to us while using our
                website or requesting our ambulance services. The information we collect may include your name, contact
                details, medical history, and demographic information. We only collect information that is necessary for
                providing our services and improving the user experience.</p>

            <h2 class="sec-title mb-3">2. Use of Information</h2>
            <ul>
                <li>Providing you with our ambulance services and ensuring efficient transportation.</li>
                <li>Responding to your inquiries, concerns, or support requests in a timely and satisfactory manner.
                </li>
                <li>Communicating important updates, changes, or notifications regarding our services.</li>
                <li>Personalizing your experience and tailoring our services to meet your individual needs and
                    preferences.</li>
                <li>Improving our website's functionality, content, and user experience through analysis of aggregated
                    usage information.</li>
            </ul>

            <h2 class="sec-title mb-3">3. Information Sharing</h2>
            <p>We respect your privacy and do not sell, rent, or disclose your personal information to third parties
                without your consent, except as required by law or to fulfill your service requests. We may share your
                information with trusted service providers who assist us in operating our website and delivering our
                services, subject to their confidentiality obligations. These service providers may include:</p>
            <ul>
                <li>Ambulance service providers.</li>
                <li>Medical professionals.</li>
                <li>Payment processors.</li>
                <li>Legal and regulatory authorities.</li>
            </ul>

            <h2 class="sec-title mb-3">4. Data Security</h2>
            <p>We take the security of your personal information seriously and implement appropriate measures to protect
                it from unauthorized access, disclosure, alteration, or destruction. We utilize industry-standard
                encryption technology to secure sensitive information transmitted between your browser and our website.
                Our security practices are regularly reviewed and updated to ensure the ongoing integrity and
                confidentiality of your information.</p>
            <p>While we implement reasonable security measures, no method of transmission or storage is completely
                secure. Therefore, we cannot guarantee the absolute security of your information. It is important to
                remember that you play a vital role in maintaining the security of your information by keeping your
                login credentials and personal information confidential.</p>

            <h2 class="sec-title mb-3">5. Cookies and Tracking Technologies</h2>
            <p>Our website may use cookies and similar tracking technologies to enhance your browsing experience,
                analyze website usage patterns, and improve our services. Cookies are small text files that are stored
                on your device and allow us to recognize you upon subsequent visits. They enable us to remember your
                preferences, customize content, and provide a more personalized experience.</p>
            <p>By using our website, you consent to the use of cookies and tracking technologies as described in this
                Privacy Policy. You have the option to manage your cookie preferences through your browser settings,
                although disabling cookies may affect certain features and functionality of our website.</p>

            <h2 class="sec-title mb-3">6. Third-Party Websites</h2>
            <p>Our website may contain links to third-party websites for your convenience and reference. We are not
                responsible for the privacy practices or content of these websites. When you access these third-party
                websites, please review their respective privacy policies and terms of service before providing any
                personal information. This Privacy Policy only applies to information collected by Urgecare through our
                website.</p>

            <h2 class="sec-title mb-3">7. Children's Privacy</h2>
            <p>Our services and website are not intended for individuals under the age of 18. We do not knowingly
                collect or solicit personal information from minors. If we become aware that we have inadvertently
                collected personal information from a minor, we will take steps to promptly delete it.</p>

            <h2 class="sec-title mb-3">8. Changes to the Privacy Policy</h2>
            <p>We reserve the right to update or modify this Privacy Policy at any time, without prior notice. Any
                changes will be effective immediately upon posting the revised Privacy Policy on our website. We
                encourage you to review this policy periodically for the latest information. Your continued use of our
                website and services after any modifications to the Privacy Policy constitutes your acceptance of the
                revised terms.</p>

            <h2 class="sec-title mb-3">9. Contact Us</h2>
            <p>If you have any questions or concerns about our Privacy Policy, or if you would like to exercise any of
                your rights regarding your personal information, please contact us using the following contact
                information:</p>
            <p>Email: {{ $setting->email ?? 'urgecarecommunications@gmail.com' }}<br>
                Phone: {{ $setting->contact_number ?? '+91 7888021021' }}</p>
            <p>Our dedicated privacy team will assist you with any inquiries or requests you may have, and we will
                strive to address your concerns promptly and effectively.</p>
        </div>
    </section>




   
@endsection