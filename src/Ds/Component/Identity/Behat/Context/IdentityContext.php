<?php

namespace Ds\Component\Identity\Behat\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Identity\Identity;

/**
 * Class IdentityContext
 */
class IdentityContext implements Context
{
    /**
     * @const string
     */
    const TOKEN_ADMIN = 'eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJhZG1pbkBkaWdpdGFsc3RhdGUuY2EiLCJ1dWlkIjoiMmFjZjNlNDctMmFjNy00YmRjLWE5M2EtNWVkZDRhMTFjZDYxIiwiaWRlbnRpdHkiOiJBZG1pbiIsImlkZW50aXR5VXVpZCI6ImJkYTE2MzRlLTYwMjgtNGNjZS1iYzFhLWI3ZTIyMGNkZjYwOSIsImlhdCI6MTUwMDUwODMyNywiZXhwIjo0NjU0MTA4MzI3fQ.bsZaEMcn0CtG_0LOkc8DYA0jfvoc6TYUbkDv1ohz9VEWpktBhf6vo5K0ELUq6-VlxbuG0AxWYyqAxfANSXkD1OtizxoKta4bHakhdY-Y0SWh-4dhgBa42AWtBFpZK5XUooLmbLKPBAJ58vfYhVwDkjF7brqTPA6P7gq-pqvdqf1fdfZQQBcb13NCrfBTkaVRaCyGOpG5h7dTF-6G_2-rehBpaw4hSt67U8VyXway2YrrBehBEVrvWdMzD_TM9lv_Ud4aXZXWgNqMt1v7V3Bo5iN3G-kvZMgFPgkTe2u7b1Vq2oMMt-JcB0qUTTJoA_7g-Xg_KJi3UlX2onS__94z6Pomv6TWzzmk-GZYNBsLVVoiBdJQxuuAE9LTIZiJ1mJzGscKDBBYA75_g5W8UNlaVrxaQPY_zUUOYuStg-FAY2SMbuxd46nvOrpFAxRwRdlpBMuz7dPeZ3RGADXMYt8gXKjZZvu1USydCoXPO0KaR0jiB-BF3BhQ18rnusiQz1Zvp51EZmdC44-bINfaKvzTJYCIoZZuxGhObiAcykGhjL8kMp2PX-E9dDAf7PKl5cXcY9FocpZAqyEEhlvpa6deOxQ_Nf8HM_la7zsedtRi5aDqNsOyrvQPwQQBbJGefv6pBp8HgRM2kiH3-VErtpw70YmSXUEWEWuzQ1rbzM5pcWQ';
    const TOKEN_SYSTEM = 'eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJzeXN0ZW1AZGlnaXRhbHN0YXRlLmNhIiwidXVpZCI6IjRiMDIzN2QxLTA5MTctNGQ4Yi1hZjZkLTJhYTg5YmUzMzZkZSIsImlkZW50aXR5IjoiU3lzdGVtIiwiaWRlbnRpdHlVdWlkIjoiZmUxYjk0ZWQtNzgzYS00OGQ3LThiZjItMmY5Y2VhODlmMTFlIiwiaWF0IjoxNTAwNTA4OTI0LCJleHAiOjQ2NTQxMDg5MjR9.Iz438ysOlSBgBviA1Xh7Imh9gqJ3OjWWam4mre1vT1ovLTK4_9flgqxVGgKCGIBVdOvsLHyAehTCKUvreoOpBXGOX22eLWz2KzaS_47r7B2kMNNyANy329cSoARUQEe5LDiK0b5hiLJWHkSIGE8duEfXojg_u3a2cG86TH6Xzp3HOZ9CU0G7Kw_O66Z8m-XjAw8_PIiE-Uf-brt2QZegLclIPcqexeEFpVR1XdcXoJaUmepuqmW0BuAybMHeTiZyYT4iitqsqZ1cAJ86uQSTSyR7vtViyq07f57NNUEMmUxfi_w92qyqPgOyQN0YAym13ad5TJbPF_Ni5rhgkmTethiYPb5EBq0h4HZRD_jlSdRiPYYbpjG08sFY2hJfW3ImlkTY7tdaaUSMzsfnzuVHDgNh4q0YpaAs01nHyJ668WGtzj---tojzWoTC6JKwatUQy65r6cC7gSxeu8p20yOx1ObDWjwEugZxWLk-0JbnUWj7XYXZyK8idwx5M20V1fgUWL7smQIX5Rnk15Vj1Jy8vy8h5deDaClbcl2WfP0ChN3pjnCZTBDeWDYOLKEeMctYMRwjvutWTzFy-XsvVs9Jz0K5-tSckH15hL6HsKyuwvQmk2FPuceecIiv6CCxejAGFLAoVOb62GhHuHuOG17-0KiD9wdKIQAV9wlTaNQG1A';
    const TOKEN_STAFF = 'eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJtYW5hZ2VyQGRpZ2l0YWxzdGF0ZS5jYSIsInV1aWQiOiIwM2Y4YzU2OS05YzVkLTQzYTgtODNiYi05Y2Y2YzkyNDllNjMiLCJpZGVudGl0eSI6IlN0YWZmIiwiaWRlbnRpdHlVdWlkIjoiNDdhNWE5Y2ItNDk2Zi00ZGI3LTg5OTktNDg5ZWM0MDQ4ODdmIiwiaWF0IjoxNTAwNTA4Nzc4LCJleHAiOjQ2NTQxMDg3Nzh9.oISKSdhqEBnO7jTuNcARZybpsz66wkDfi3rZ4XEMIuuCXtRGn3pW7RfBRwxl9X1rF5eA8pzEB-7AqrDgPdz6qBMuCUOZxQ90-asiBatXPcCpntVzf0n8kZeaMQZL1bfGzUD5aJuxZOegLA0CpYpAYN5fzw4L8V_eo4N3knrSCC-wzZNKlFicTsJig0-aIMD4BC0HoatKMuvgbri8XG7Ey2drKhYmNuQyOJoGa3pgmrIRNAeNYPz0D6HTDkzRzDOiAZZsHi8ccKXqEoMVLPJgejXLhzCm_8fgRO-Z08rR_zJqqNI12G4BkGh6Bc2TWhV8kx76BuauwpU6t958kkwLJruKe4YN59aWUGlYWAxX0R5IvZkIVrHzgn81OD3U7GSI53dEadx2DEu5NZeP23tP37VxgCKB_ZAk0HHNT6wVKJAN1gMUxvjJQ0pRaWLGyU0Gtkukpv2VqihFxmKFVJbPuU11NCRaV7IHllti6F4Lk9gZ1TAxLv91G4BkrtPThacVXkhQjwh0Gy9N2pEpwYcSQaHv1Yt7IsfUHjYW8koKUpJvlK_q66Ffjw4QVYlBGs2mQ5D3nJR8ocEX7dqVz6q8dxmVe4_OjVQFqEAPReV5iY9RHFmGhkctIjeXrZJgtuHSZgZCDeUdaY1C8nkLWbB17oytWO6re2p6c9rfY-hdoWM';
    const TOKEN_INDIVIDUAL = 'eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJtb3JnYW5Ac2l0ZS5jb20iLCJ1dWlkIjoiNDIxODJmZDAtOTY2NS00YmE0LTlmNWMtZWMyOTBlMjM4MTRlIiwiaWRlbnRpdHkiOiJJbmRpdmlkdWFsIiwiaWRlbnRpdHlVdWlkIjoiZDBkYWE3ZTQtMDdkMS00N2U2LTkzZjItMDYyOWFkYWEzYjQ5IiwiaWF0IjoxNTAwNTA4Nzk2LCJleHAiOjQ2NTQxMDg3OTZ9.au0uqY_LBFQuF56er1jzJBdoohGHmRSf524OauyLn6EYbS-eeCr73B9OigcvMO5lU_PUXeV1gLsCjM4amE81qm2r-VVHJphRDMCL7TVA_ZtFT5MgbmeEzf9iWIAJng0uN6PHGulfJLEDvUlQgGjsOipKn9L1w3GMkr7RgSCxV4hI8pK5lCEFmbLPC3nWeUa-8OtKaV4ltBcH3nyHd-zMGhnzNZB4UrVP_5cUjrKNDvkxLvGxCy1jDEB0u6hYj4ZTqF6kOEV4YUVimxg_Jhq5pIaa0qtaK5EFS2AcoQtZv7flbnfzzSQPF3feEXIOe0VDHfdzgdSvzGEVHv3TP0fZX1yr2ANLNSXH8QW4P_qjIRl91-dfs7914-A2faVbQ1VfF9dr8ZA0WuFDSQZN7vMV7xQYYerrSUXs8hRXYAMyBLwFlRLYHps8fWMjk1DapGreEPTdpoR1pAGxuiX_3YT3TsKpK6OhZKTUhpRZHtMUMF7ZKL2p8LAaQ9cdL-9EBpZgKAvrSPSSnnuNnY2UYeC8UfIcONygsifdQgnh3gQ07csBC1N9-LcuZ3vRmfADyGVLM8Jnm1hcoyeLbcNFTwrE3diKZ8ud-9EN7l4gYPvwCSWY3mqlukiLrIbK5_mAVNlQabsyrh2CoM1mzkiWHHo0vrUNgLqK2QXfw1WdJdFlfBU';
    const TOKEN_ANONYMOUS = 'eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJhbm9ueW1vdXNAZGlnaXRhbHN0YXRlLmNhIiwidXVpZCI6Ijk0NTgyNGYyLTMwOTktNDQyZC1hYzRmLTZjODY3YTE2OTJlNiIsImlkZW50aXR5IjoiQW5vbnltb3VzIiwiaWRlbnRpdHlVdWlkIjpudWxsLCJpYXQiOjE1MDA1MDg4MTQsImV4cCI6NDY1NDEwODgxNH0.Czw52KCVZkzx_A9Tn6GjekWIsAZmDCMlkvc6g3qVRG082myQxqVbCF5APGyUS9NGss1NgfDHEa2bWMuQKm8YADfe5HNiXGiH4ZWsrlwg9k0sPF5bfm9qcHN5BrtuFr-7pQkX_8w7RVnu3IxexA19E1LgceoH317bAN0NxTMSaaXTzNhpBe8z-pKQCdyYBUS4ojn6-Hux6WYrfVx6tFmBGqPSqd55bmNwHsGVLDUtj1F44Pi37RuiAgI3AooxrZD-uQV9Vk9bVDS5CYolqtfPNaIZ4Wdjgk5ZwdZGeSOzcfP7vM38OxlPWsya2mQ1YQPz_E2Rf7gSkOb9Z8A-M07HnScG-zd1jeMGKzRP0LAqBPNZbRjfu3a2a-2Zje3jP-eJuKbliyQa2NCCc_qs8O1DVRWdD3AqQ2eIg462_koY0eBM24pddiDTfZnM7McIZwyVo9c-opXRIa39Aifgsa_O6qn-UrQ4SC9YaVjYk1rW0nW9AqBFG4S-4M7YUlaVtBSckz4RaBsVV9cSGJGEpmzg6ojxHdeDE_U74SUlr5DFq7wn_1m6ll55lcEAPtJ03aviPdRqcXN6kGniD_3Yf371QovfJ1-XoxKzsqUMBS7BhFGPgavIhgfxXNgZaNQogjn8kMIadPZkEHL7lRwaD1rIjmuXa4w0CXkf60IIL4ppkkc';

    /**
     * @var \Behatch\HttpCall\Request
     */
    protected $request;

    /**
     * Constructor
     *
     * @param \Behatch\HttpCall\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @Given I am authenticated as an :identity identity
     */
    public function iAmAuthenticatedAsAnIdentity($identity)
    {
        switch ($identity) {
            case Identity::ADMIN:
                $token = static::TOKEN_ADMIN;
                break;

            case Identity::SYSTEM:
                $token = static::TOKEN_SYSTEM;
                break;

            case Identity::STAFF:
                $token = static::TOKEN_STAFF;
                break;

            case Identity::INDIVIDUAL:
                $token = static::TOKEN_INDIVIDUAL;
                break;

            case Identity::ANONYMOUS:
                $token = static::TOKEN_ANONYMOUS;
                break;

            default:
                throw new DomainException('Identity does not exist.');
        }

        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
