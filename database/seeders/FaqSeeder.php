<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Urgecare?',
                'answer' => 'Urgecare is an ambulance aggregator platform based in Pune, Maharashtra, India. We provide reliable and efficient emergency and non-emergency medical transportation services. Our goal is to bridge the gap in emergency care accessibility and ensure timely medical assistance reaches those in need.',
                'order' => 1
            ],
            [
                'question' => 'What types of ambulance services does Urgecare offer?',
                'answer' => 'Urgecare offers a range of ambulance services to cater to different medical needs. We provide basic life support (BLS) ambulances, advanced life support (ALS) ambulances, and critical care units (CCU) equipped with advanced medical equipment and staffed by trained medical professionals.',
                'order' => 2
            ],
            [
                'question' => 'How can I request an ambulance through Urgecare?',
                'answer' => 'To request an ambulance, you can contact our 24/7 helpline number or visit our website. Our dedicated team will assist you in arranging the appropriate ambulance based on your medical requirements.',
                'order' => 3
            ],
            [
                'question' => 'Does Urgecare offer non-emergency medical transportation services?',
                'answer' => 'Yes, Urgecare provides non-emergency medical transportation services. Whether you need transportation for medical appointments, hospital discharges, or intercity transfers, we ensure a comfortable and seamless experience.',
                'order' => 4
            ],
            [
                'question' => 'How does Urgecare ensure patient comfort during transportation?',
                'answer' => 'At Urgecare, we prioritize patient comfort. Our ambulances are equipped with features like comfortable seating, proper ventilation, temperature control, and noise reduction measures. We strive to create a safe and comfortable environment for patients throughout their journey.',
                'order' => 5
            ],
            [
                'question' => 'Does Urgecare provide specialized care for patients with unique medical needs?',
                'answer' => 'Yes, we offer specialized care for patients with disabilities, elderly individuals, and those requiring additional assistance during transportation. Our medical staff undergo specific training to handle special cases and ensure patients receive personalized care, comfort, and support.',
                'order' => 6
            ],
            [
                'question' => 'Can Urgecare arrange medical escorts for travel by commercial flights?',
                'answer' => 'Absolutely. We provide medical escort services for patients requiring medical support during travel by commercial flights. Our experienced medical professionals accompany patients, ensuring their safety, comfort, and continuity of care throughout the journey.',
                'order' => 7
            ],
            [
                'question' => 'Does Urgecare offer event medical coverage services?',
                'answer' => 'Yes, Urgecare offers comprehensive event medical coverage services for public gatherings, sports events, concerts, and festivals. We deploy a team of medical professionals equipped with mobile medical units to provide on-site emergency medical services during events.',
                'order' => 8
            ],
            [
                'question' => 'Does Urgecare provide air ambulance services?',
                'answer' => 'Yes, in critical situations that require immediate transportation over long distances, Urgecare provides air ambulance services. We work closely with leading air ambulance providers to facilitate swift and efficient air transportation for patients. Our air ambulance services include arranging medical staff, specialized equipment, and ensuring a smooth transition from ground to air transportation, prioritizing the well-being and safety of the patient.',
                'order' => 9
            ],
            [
                'question' => 'How can I rent medical equipment from Urgecare?',
                'answer' => 'Urgecare provides medical equipment rental services, allowing individuals to temporarily access essential medical equipment. You can contact us to inquire about the availability and rental process for equipment such as wheelchairs, crutches, and other medical aids.',
                'order' => 10
            ],
            [
                'question' => 'Are the ambulance services available 24/7?',
                'answer' => 'Yes, Urgecare operates 24/7, ensuring that assistance is available whenever you need it. Our helpline is accessible round the clock for ambulance requests, inquiries, and any other assistance you may require.',
                'order' => 11
            ],
            [
                'question' => 'Are the medical professionals at Urgecare trained and certified?',
                'answer' => 'Yes, all our medical professionals, including paramedics and nurses, are trained and certified. They possess the necessary qualifications and experience to provide quality medical care during transportation.',
                'order' => 12
            ],
            [
                'question' => 'How is the privacy of patients maintained during transportation?',
                'answer' => 'Urgecare takes patient privacy seriously. We adhere to strict confidentiality protocols and ensure that all patient information remains confidential and secure during transportation and consultations.',
                'order' => 13
            ],
            [
                'question' => 'How are the ambulance crews selected at Urgecare?',
                'answer' => 'We have a rigorous selection process for our ambulance crews. They undergo thorough background checks, possess the required certifications, and have a proven track record in the medical field. We prioritize professionalism and competence when selecting our staff.',
                'order' => 14
            ],
            [
                'question' => 'What safety measures are in place to protect patients during transportation?',
                'answer' => 'Urgecare places a strong emphasis on patient safety. Our ambulances are equipped with safety features such as seat belts, secure medical equipment storage, and adherence to strict infection control protocols. Our medical professionals are trained in emergency procedures to handle any unforeseen circumstances during transportation.',
                'order' => 15
            ],
            [
                'question' => 'How are the prices for ambulance services determined?',
                'answer' => 'The prices for our ambulance services are determined based on several factors, including the type of ambulance required, the distance of transportation, and any additional services or equipment needed. We strive to provide transparent pricing and ensure that our services are affordable and value-driven.',
                'order' => 16
            ],
            [
                'question' => 'Can Urgecare handle medical transportation for patients with specific medical conditions?',
                'answer' => 'Yes, we can handle medical transportation for patients with specific medical conditions. Our medical staff is trained to provide specialized care and ensure the safety and well-being of patients with various medical conditions, including cardiac issues, respiratory conditions, and other critical illnesses.',
                'order' => 17
            ],
            [
                'question' => 'What should I do in case of a medical emergency?',
                'answer' => 'In case of a medical emergency, call our helpline number immediately. Our team will guide you on the necessary steps to take, provide medical advice if possible, and dispatch an ambulance to your location promptly.',
                'order' => 18
            ],
            [
                'question' => 'Is Urgecare recognized by insurance providers?',
                'answer' => 'Yes, Urgecare is recognized by various insurance providers. We work with insurance companies to facilitate direct billing and claim processing, making it convenient for patients to utilize their insurance coverage for medical transportation services.',
                'order' => 19
            ],
            [
                'question' => 'How can I provide feedback or make a complaint about Urgecare\'s services?',
                'answer' => 'We value feedback from our customers as it helps us improve our services. You can provide feedback or make a complaint by reaching out to our customer support team through our helpline or email. We will address your concerns promptly and take appropriate action.',
                'order' => 20
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
