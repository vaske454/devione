import { Link, Head } from '@inertiajs/react';
import WordInput from '../Components/WordInput';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome"/>
            <div className="welcome-container">
                <h1 className="welcome-title">Welcome to the Word Game!</h1>
                <WordInput/>
            </div>
        </>
    );
}
