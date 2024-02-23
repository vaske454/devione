import { Link, Head } from '@inertiajs/react';
import WordInput from '../Components/WordInput';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome"/>
            <div className="mt-8 max-w-md mx-auto text-center">
                <h1 className="text-3xl font-bold mb-4">Welcome to the Word Game!</h1>
                <WordInput/>
            </div>
        </>
    );
}
